<?php

namespace app\commands;

use app\components\DailyPricing;
use app\components\ManageMikrotik;
use app\components\Microtik;
use app\components\Pricing;
use app\modules\crm\models\CrmDealVacation;
use app\modules\fastnet\models\Deal;
use app\modules\fastnet\models\DealBallance;
use app\modules\fastnet\models\DisabledDay;
use Carbon\Carbon;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;
use yii2mod\collection\Collection;

require_once __DIR__ . '/../components/routeros_api.class.php';

class DealController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    /**
     * @param $dealId
     * @param $startDate
     * @param $endDate
     * @param bool $balance
     * @return array|false|\yii\db\DataReader
     * @throws \yii\db\Exception
     */
    public function monthlyDealBalance($dealId, $startDate, $endDate, $balance = true) {

        $table = $balance ? 'f_deal_ballance' : 'deal_payment_log';
        $dateColumn = $balance ? 'date' : 'create_at';

        $sql = "SELECT * FROM `{$table}`
                    WHERE DATE_FORMAT(`{$dateColumn}`, '%Y-%m') BETWEEN '{$startDate}' AND '{$endDate}'
                    AND `deal_id` = {$dealId}";

        if ($balance) {
            return Yii::$app->db->createCommand($sql)->queryOne();
        } else {
            return Yii::$app->db->createCommand($sql)->queryAll();
        }
    }

    /**
     * Daily deal monthly clone.
     */
    public function actionCloneDailyDeals() {
        $currentDate = Carbon::now()->toDateString();
        $currentDatePlusOneMonth = Carbon::now()->addMonth()->toDateString();

        $currentActiveDeal = Deal::find()
            ->where(['daily_month_end' => $currentDate])
            ->isDaily()
            ->statusHas([Deal::ACTIVE, Deal::DISABLED, Deal::NO_INTERNET])
            ->all();

        if (!empty($currentActiveDeal)) {
            $transaction = Yii::$app->db->beginTransaction();

            try {

                foreach ($currentActiveDeal as $deal) {

                    $newDeal = new Deal();
                    $results = ArrayHelper::toArray($deal);
                    $newDeal->load($results, '');

                    # Get closed deal balance
                    $balance = DealBallance::findOne(['deal_id' => $deal->id]);

                    # Create new balance for new deal
                    $newBalance = new DealBallance();

                    # Closed deal pricing instance
                    $dealPricing = new DailyPricing($deal);

                    # Deal calculation for new balance
                    $sale = $deal->sale ? floatval($deal->sale->price) : 0;
                    $totalSum = ($dealPricing->totalDealAmount() - $sale) + ($balance ? $balance->balance : 0 + $dealPricing->sumIPPrice());

                    if ($balance && $balance->balance <= 0) {

                        # New deal attributes
                        if (!$newDeal->isActive()) {
                            $newDeal->setActiveStatus();

                            # Enable mikrotik if status disabled and has no debt
                            $mikrotik = new ManageMikrotik($newDeal);
                            $mikrotik->createNewFirewall();
                        }

                        $newDeal->daily_month_end = $currentDatePlusOneMonth;
                        $newDeal->connection_day = $currentDate;
                        $newDeal->month -= 1;

                        # New deal balance attributes
                        $newBalance->balance = $totalSum;
                    } else {
                        # New deal attributes
                        if ($deal->isActive()) {
                            $newDeal->setDisabledStatus();

                            # Disable mikrotik if status active and has debt
                            $mikrotik = new ManageMikrotik($deal);
                            $mikrotik->removeFirewall();
                        }

                        $dealOneMonthDate = Carbon::parse($deal->balance->date)->format('Y-m');
                        $prevMonth = Carbon::now()->subMonthNoOverflow()->format('Y-m');

                        # Select all payments for one month
                        $oneMonthPayment = $this->monthlyDealBalance($deal->id, $prevMonth, $dealOneMonthDate, false);

                        # Deal total sum with penalty
                        $penalty = $deal->penalty ? floatval($deal->penalty) : 0;
                        $totalPayedForMonthPeriod = Collection::make($oneMonthPayment)->sum(function ($payment) {
                            return $payment['price'] ?: 0;
                        });

                        $newBalance->balance = ($totalSum + $penalty) - $totalPayedForMonthPeriod;
                    }

                    # Close old deal
                    $deal->is_active = Deal::INACTIVE;
                    $deal->setClosedStatus();
                    $deal->save();

                    # Create new deal
                    $newDeal->start_day = $deal->start_day;
                    $newDeal->is_active = Deal::IS_ACTIVE;
                    $newDeal->save();

                    # Create new balance for new deal
                    $newBalance->deal_number = $newDeal->deal_number;
                    $newBalance->deal_id = $newDeal->id;
                    $newBalance->date = $currentDate;
                    $newBalance->save();

                    # Move agreement from old deal to new deal
                    if ($deal->agreement) {
                        $agreement = $deal->agreement;
                        $agreement->deal_id = $newDeal->id;
                        $agreement->save();
                    }
                }

                $transaction->commit();
                return ExitCode::OK;

            } catch (\Exception $exception) {
                if (YII_DEBUG) {
                    echo $exception->getLine() . ': ' . $exception->getMessage();
                }
                $transaction->rollBack();
            }
        }
    }

    /**
     * Default deal monthly cron for contact.
     *
     * @return int|string
     */
    public function actionClone() {

        $currentActiveDeal = Deal::find()
            ->isNotDaily()
            ->statusHas([Deal::ACTIVE, Deal::VACATION, Deal::DISABLED])
            ->contact()
            ->all();

        if(!empty($currentActiveDeal)) {

            $transaction = \Yii::$app->db->beginTransaction();

            try {
                foreach($currentActiveDeal as $c_a_deal) {
                    $newDeal = new Deal();
                    $results = ArrayHelper::toArray($c_a_deal);
                    $newDeal->load($results, '');

                    $newDeal->start_day = $c_a_deal->start_day;

                    # Mi or het e sarqum
                    if ($c_a_deal->isActive()) {
                        $newDeal->connection_day = date('Y-m-d', strtotime('+1 days'));
                    }

                    $newDeal->status = $c_a_deal->status;
                    $newDeal->is_active = Deal::IS_ACTIVE;
                    $newDeal->start_deal = 0;

                    if ($newDeal->save()) {

                        if (YII_DEBUG) {
                            echo 'New deal created: ' . $newDeal->deal_number . PHP_EOL;
                        }

                        $oldBalance = new Pricing($c_a_deal);
                        $newModelBalance = new Pricing($newDeal);

                        // Add new balance for each new created deal for balance history
                        $currentBalance = new DealBallance();
                        $currentBalance->date = date('Y-m-d', strtotime('+1 days'));
                        $currentBalance->deal_id = $newDeal->id;
                        $currentBalance->deal_number = $c_a_deal->deal_number;

                        switch($c_a_deal->status) {
                            case Deal::ACTIVE :
                                $sale = $c_a_deal->sale ? floatval($c_a_deal->sale->price) : 0;
                                $currentBalance->balance = ($newModelBalance->totalDealAmount() - $sale) + (($c_a_deal->balance->balance + $newModelBalance->sumIPPrice()) - $oldBalance->currentMonthTotalPayed());
                                break;
                            case Deal::VACATION :
                                /* ste pti hashvark katarvi ete ekoq voxj amsva @ntackum chi ardzakurd*/
                                $leftPrice = $oldBalance->vacationPrice();
                                if (!empty($leftPrice) && !empty($leftPrice['currentBalanceWithMonth'])) {
                                    $changedMonthPrice = $leftPrice['currentBalanceWithMonth'][date('Y-m')];
                                    $oldPrice = $oldBalance->virtualBalance() - $oldBalance->currentMonthTotalPayed();
                                    $currentBalance->balance = $changedMonthPrice + $oldPrice;
                                }
                                break;
                            case Deal::DISABLED:
                                $currentBalance->balance = $oldBalance->oldBalance($newDeal);
                                break;
                            default:
                                break;
                        }

                        $c_a_deal->setClosedStatus();
                        $c_a_deal->is_active = Deal::INACTIVE;

                        if ($c_a_deal->save()) {
                            if (YII_DEBUG) {
                                echo 'Current deal status changed to: ' . $c_a_deal->status . PHP_EOL;
                            }

                            if ($currentBalance->save()) {
                                if (YII_DEBUG) {
                                    echo 'Current deal balance saved. Price: ' . $currentBalance->balance . PHP_EOL;
                                }
                            } else {
                                if (!YII_DEBUG) {
                                    echo 'Balance error: ' . PHP_EOL;
                                }
                            }

                        } else {
                            if (!YII_DEBUG) {
                                echo 'Current deal error: ' . PHP_EOL;
                            }
                        }

                    } else {
                        if (!YII_DEBUG) {
                            echo 'New deal error: ' . PHP_EOL;
                        }
                    }
                }

                $transaction->commit();
                return ExitCode::OK;

            } catch (\Exception $exception) {
                if (YII_DEBUG) {
                    echo $exception->getLine() . ': ' . $exception->getMessage();
                }
                $transaction->rollBack();
            }

        }else{
            return 'empty Data';
        }
    }

    /**
     * Default deal monthly cron for company.
     *
     * @return int|string
     */
    public function actionCloneCompany() {
        $currentActiveDeal = Deal::find()
            ->isNotDaily()
            ->statusHas([Deal::ACTIVE, Deal::VACATION, Deal::DISABLED])
            ->company()
            ->all();

        if(!empty($currentActiveDeal)) {

            $transaction = \Yii::$app->db->beginTransaction();

            try {
                foreach($currentActiveDeal as $c_a_deal) {
                    $newDeal = new Deal();
                    $results = ArrayHelper::toArray($c_a_deal);
                    $newDeal->load($results, '');

                    $newDeal->start_day = $c_a_deal->start_day;

                    if ($c_a_deal->isActive()) {
                        $newDeal->connection_day = Carbon::now()->toDateString();
                    }

                    $newDeal->status = $c_a_deal->status;
                    $newDeal->is_active = Deal::IS_ACTIVE;

                    if ($newDeal->save()) {

                        if (YII_DEBUG) {
                            echo 'New deal created: ' . $newDeal->deal_number . PHP_EOL;
                        }

                        $oldBalance = new Pricing($c_a_deal);
                        $newModelBalance = new Pricing($newDeal);

                        // Add new balance for each new created deal for balance history
                        $currentBalance = new DealBallance();
                        $currentBalance->date = Carbon::now()->toDateString();
                        $currentBalance->deal_id = $newDeal->id;
                        $currentBalance->deal_number = $c_a_deal->deal_number;

                        switch($c_a_deal->status) {
                            case Deal::ACTIVE :
                                $sale = $c_a_deal->sale ? floatval($c_a_deal->sale->price) : 0;
                                $currentBalance->balance = ($newModelBalance->totalDealAmount() - $sale) + (($c_a_deal->balance->balance + $newModelBalance->sumIPPrice()) - $oldBalance->currentMonthTotalPayed());
                                break;
                            case Deal::VACATION :
                                /* ste pti hashvark katarvi ete ekoq voxj amsva @ntackum chi ardzakurd*/
                                $leftPrice = $oldBalance->vacationPrice();
                                if (!empty($leftPrice) && !empty($leftPrice['currentBalanceWithMonth'])) {
                                    $changedMonthPrice = $leftPrice['currentBalanceWithMonth'][date('Y-m')];
                                    $oldPrice = $oldBalance->virtualBalance() - $oldBalance->currentMonthTotalPayed();
                                    $currentBalance->balance = $changedMonthPrice + $oldPrice;
                                }
                                break;
                            case Deal::DISABLED:
                                $currentBalance->balance = $oldBalance->oldBalance($newDeal);
                                break;
                            default:
                                break;
                        }

                        $c_a_deal->setClosedStatus();
                        $c_a_deal->is_active = Deal::INACTIVE;

                        if ($c_a_deal->save()) {
                            if (YII_DEBUG) {
                                echo 'Current deal status changed to: ' . $c_a_deal->status . PHP_EOL;
                            }

                            if ($currentBalance->save()) {
                                if (YII_DEBUG) {
                                    echo 'Current deal balance saved. Price: ' . $currentBalance->balance . PHP_EOL;
                                }
                            } else {
                                if (!YII_DEBUG) {
                                    echo 'Balance error: ' . PHP_EOL;
                                }
                            }

                        } else {
                            if (!YII_DEBUG) {
                                echo 'Current deal error: ' . PHP_EOL;
                            }
                        }

                    } else {
                        if (!YII_DEBUG) {
                            echo 'New deal error: ' . PHP_EOL;
                        }
                    }
                }

                $transaction->commit();
                return ExitCode::OK;

            } catch (\Exception $exception) {
                if (YII_DEBUG) {
                    echo $exception->getLine() . ': ' . $exception->getMessage();
                }
                $transaction->rollBack();
            }

        }else{
            return 'empty Data';
        }
    }

    /**
     * Disable service for contact.
     *
     * @return array|bool|int
     * @throws \Throwable
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionDisabled() {
        $disabled = DisabledDay::find()->one();
        $currentDate = Carbon::now()->toDateString();

        $dDay = $disabled->disabled_day <= 9 ? '0'.$disabled->disabled_day : $disabled->disabled_day;

        $disabledDay = date("Y-m-{$dDay}");

        if($currentDate == $disabledDay) {

            $deals = Deal::find()
                ->isNotDaily()
                ->active()
                ->contact()
                ->isNotProvider()
                ->all();

            if (empty($deals)) {
                return ExitCode::UNAVAILABLE;
            }

            $errors = [];

            foreach ($deals as $deal) {

                $pricing = new Pricing($deal);
                $total = $pricing->virtualBalance() - $pricing->currentMonthTotalPayed();

                if($total > $disabled->price){
                    $deal->setDisabledStatus();

                    if ($deal->save()) {
                        if($deal->deal_number == '123245'){
                            $mikrotik = new ManageMikrotik($deal);
                            $mikrotik->removeFirewall();
                        }


                    }
                }
            }

            if (!empty($errors)) {
                var_dump($errors);
            } else {
                return ExitCode::OK;
            }
        }

        return ExitCode::UNAVAILABLE;
    }

    public function actionTestInet(){

        $deal = Deal::findOne(66);
        $mikrotik = new Microtik();

        var_dump($mikrotik->removeToMicro('10.51.192.21'));die;
         var_dump($mikrotik->writeToMicro('UNLIMITED-SURFING-3', '10.51.192.21', 'UID_UIP/UBITS_SURFING-3'));die;
    }

//    public function actionTestInet(){
//
//        $deal = Deal::findOne(66);
//        $mikrotik = new ManageMikrotik($deal);
//
//        var_dump($mikrotik->createNewFirewall());die;
//    }


    /**
     * @return int
     * @throws \Throwable
     */
    public function actionAddVacation() {
        $getVacation = CrmDealVacation::find()
            ->where('data_start = CURDATE()')->andWhere(['status' => 1])
            ->all();

        if (!empty($getVacation)) {

            $transaction = Yii::$app->db->beginTransaction();

            try {
                foreach ($getVacation as $vacation) {
                    $deal = $vacation->dealVacation;

                    $vacation->status = 2;
                    $vacation->save();

                    # New Vacation logic start
                    $modelPricing = new Pricing($deal);
                    $startMonthBalance = $modelPricing->virtualBalance(false, $deal->connection_day, true);
                    $vacationBalance = $modelPricing->vacationPrice()['currentBalanceWithMonth'][date('Y-m')];
                    $vacDayPrice = $startMonthBalance - $vacationBalance;

                    $deal->balance->balance = ($deal->balance->balance - $vacDayPrice);

                    if ($deal->balance->save()) {

                        if ($vacation->save()) {
                            $deal->setVacationStatus();

                            if ($deal->save()) {
                                $mikrotik = new ManageMikrotik($deal);
                                $mikrotik->removeFirewall();

                                # Check if mikrotik removed before commit transaction
                                $transaction->commit();
                            }
                        }
                    }
                }

                return ExitCode::OK;
            } catch (\Exception $ex) {
                echo $ex->getMessage();
                $transaction->rollBack();
                return ExitCode::UNAVAILABLE;
            }
        }
        
        return ExitCode::UNAVAILABLE;
    }

    /**
     * @return int
     */
    public function actionEndVacation() {
        $getVacation = CrmDealVacation::find()
            ->where('data_end = CURDATE()')
            ->andWhere(['status' => 2])
            ->all();

        if (!empty($getVacation)) {

            $transaction = Yii::$app->db->beginTransaction();

            try {
                foreach ($getVacation as $vacation) {
                    $deal = $vacation->dealVacation;
                    $deal->setActiveStatus();

                    if ($deal->save()) {
                        # Update existing balance
                        # End vacation
                                $vacation->status = 0;
//                                $vacation->data_end = date('Y-m-d H:i:s');


                                if ($vacation->save()) {
                                    # If the vacation is over add to mikrotik
                                    $mikrotik = new ManageMikrotik($deal);
                                    $mikrotik->createNewFirewall();

                                    $transaction->commit(); // Add if statement
                                }


                    }
                }

                return ExitCode::OK;
            } catch (\Exception $ex) {
                echo $ex->getMessage();
                $transaction->rollBack();
                return ExitCode::UNAVAILABLE;
            }
        }

        return ExitCode::UNAVAILABLE;
    }

    /**
     * Set default internet speed if speed date end is current date.
     *
     * @return int
     */
    public function actionSpeedLimit() {
        $dealQuery = Deal::find()
            ->where('speed_date_end = CURDATE()')
            ->all();

        if (!empty($dealQuery)) {
            foreach ($dealQuery as $deal) {

                # Set tariff default internet speed
                $limit = $deal->tariff->inet_speed ?: null;
                $deal->binding_speed = null;
                $deal->down_binding_speed = null;
                $deal->speed_date_start = null;
                $deal->speed_date_end = null;

                if ($deal->save()) {
                    $mikrotik = new ManageMikrotik($deal);
                    $mikrotik->setLimit($limit);
                    $mikrotik->updateFirewall();
                }
            }

            return ExitCode::OK;
        }

        return ExitCode::UNAVAILABLE;
    }

    /**
     * @throws \yii\db\Exception
     */
    public function actionConnectPrice(){
        $disabled = DisabledDay::find()->one();
        $minPrice = $disabled->price;
        $noInternet = Deal::find()->noInternet()->all();
        foreach ($noInternet as $deal){
            $pricing = new Pricing($deal);
            if($minPrice >= ($pricing->virtualBalance() - $pricing->currentMonthTotalPayed())){
                if (!$deal->balance) {
                    $balance = new DealBallance();
                    $balance->deal_id = $deal->id;
                    $balance->deal_number = $deal->deal_number;
                    $balance->balance = $pricing->virtualBalance(false);
                    $balance->date = date('Y-m-d');
                    $balance->save();

                    $deal->connection_day = date('Y-m-d');
                }
                        $deal->status = Deal::ACTIVE;
                        if ($deal->save()) {
                        $mikrotik = new ManageMikrotik($deal);
                        $mikrotik->createNewFirewall();
                    }

            }
        }
    }

}