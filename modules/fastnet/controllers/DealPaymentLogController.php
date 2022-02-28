<?php

namespace app\modules\fastnet\controllers;

use app\components\DailyPricing;
use app\components\Helper;
use app\components\ManageMikrotik;
use app\components\Pricing;
use app\modules\billing\models\DealPaymentLogDailySearch;
use app\modules\billing\models\DealPaymentLogDefaultSearch;
use app\modules\billing\models\DealPaymentLogHistory;
use app\modules\crm\models\Cashier;
use app\modules\crm\models\CashRegisterReceipt;
use app\modules\fastnet\models\Deal;
use app\modules\fastnet\models\DisabledDay;
use app\traits\FindModelTrait;
use Carbon\Carbon;
use Yii;
use app\modules\billing\models\DealPaymentLog;
use app\modules\billing\models\DealPaymentLogSearch;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Request;

/**
 * DealPaymentLogController implements the CRUD actions for DealPaymentLog model.
 */
class DealPaymentLogController extends Controller
{

    use FindModelTrait;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all DealPaymentLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DealPaymentLogSearch();
        $searchModelDaily = new DealPaymentLogDailySearch();
        $searchModelDefault = new DealPaymentLogDefaultSearch();

        # Select virtual cashier by authenticated user id.
        $isVirtualCashier = Cashier::find()
            ->active()
            ->virtual()
            ->getByOperatorId(Yii::$app->user->id)
            ->one();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, !empty($isVirtualCashier));
        $dataProviderDaily = $searchModelDaily->search(Yii::$app->request->queryParams, !empty($isVirtualCashier));
        $dataProviderDefault = $searchModelDefault->search(Yii::$app->request->queryParams, !empty($isVirtualCashier));

        $getCashiers = Cashier::find()
            ->active()
            ->notVirtual()
            ->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelDaily' => $searchModelDaily,
            'dataProviderDaily' => $dataProviderDaily,
            'searchModelDefault' => $searchModelDefault,
            'dataProviderDefault' => $dataProviderDefault,
            'cashiers' => $getCashiers,
            'isVirtual' => !empty($isVirtualCashier)
        ]);
    }

    /**
     * Displays a single DealPaymentLog model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel(DealPaymentLog::class, $id);

        return $this->renderAjax('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new DealPaymentLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DealPaymentLog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DealPaymentLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel(DealPaymentLog::class, $id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Total paid price for grid selected rows.
     *
     * @return bool|int|mixed|string|null
     */
    public function actionTotalPaid() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {
            $total = DealPaymentLog::find()->where(['IN', 'id', Yii::$app->request->post()['id']])->sum('price');
            return Helper::removeUselessZeroDigits($total);
        } else {
            return 0;
        }
    }

    /**
     * @return bool
     */
    public function actionSetPaidSelectedItems() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {
            $user = Yii::$app->user->identity;
            $idGroup = Yii::$app->request->post()['id'];

            $transaction = Yii::$app->db->beginTransaction();

            try {
                $paymentLogQuery = DealPaymentLog::find()->where(['IN', 'id', $idGroup])->all();

                if (!empty($paymentLogQuery)) {
                    foreach ($paymentLogQuery as $paymentLog) {
                        $paymentLog->update_at = date('Y-m-d H:i:s');
                        $paymentLog->payer = $user->cashierOperator->cashier_id;
                        $paymentLog->save();
                    }

                    $transaction->commit();
                }

                return true;
            } catch (\Exception $exception) {
                $transaction->rollBack();
                return false;
            }
        }

        return false;
    }

    /**
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionPaymentChange() {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();

            $paymentLogs = !empty($post['ids']) ? DealPaymentLog::find()->where(['IN', 'id', $post['ids']])->all() : [];

            # Whitelisted deal if the payment cashier is blacklisted and the payment is current month
            $whiteDealSqlQuery = "SELECT `deal_payment_log`.*, `f_deal`.`deal_number` FROM `deal_payment_log`
                                LEFT JOIN `f_deal` ON `deal_payment_log`.`deal_id` = `f_deal`.`id`
                                LEFT JOIN `f_cashier` ON `deal_payment_log`.`operator_id` = `f_cashier`.`id`
                                WHERE MONTH(deal_payment_log.create_at) = MONTH(CURRENT_DATE())
                                AND `f_deal`.`blacklist` = " . Deal::BLACKLIST_WHITE . "
                                AND `f_cashier`.`blacklist` = " . Cashier::BLACKLIST_BLACK . "
                                AND `f_cashier`.`virtual` = " . Cashier::NOT_VIRTUAL;

            $whiteDealQuery = Yii::$app->db->createCommand($whiteDealSqlQuery)->queryAll(\PDO::FETCH_OBJ);

            # Need refactoring
//            $whiteDealQuery = DealPaymentLog::find()
//                ->joinWith('deal')
//                ->joinWith('cashier')
//                ->andFilterWhere(['f_deal.blacklist' => Deal::BLACKLIST_WHITE])
//                ->andFilterWhere(['f_cashier.blacklist' => Cashier::BLACKLIST_BLACK])
//                ->andWhere('MONTH(deal_payment_log.create_at) = MONTH(CURRENT_DATE())')
//                ->all();

            $whiteDeal = [];

            if (!empty($whiteDealQuery)) {

                foreach ($whiteDealQuery as $item) {
                    $whiteDeal[$item->id] = $item->deal_number . ' / ' . $item->price;
                }
            }

            return $this->renderAjax('partials/_payment_change', ['paymentLogs' => $paymentLogs, 'whiteDeal' => $whiteDeal]);
        }
    }

    /**
     * Get deal for remove in wrongly paid modal.
     *
     * @return string
     */
    public function actionWrongPaymentChange() {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();

            $dealPaymentLog = DealPaymentLog::find()->where(['id' => $post['ids'][0]])->one();

            return $this->renderAjax('partials/_wrong_payment_change', ['paymentLog' => $dealPaymentLog]);
        }
    }

    /**
     * Switch deal cashier.
     *
     * @return string
     */
    public function actionSwitchCashier() {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();

            if (isset($post['ids']) && !empty($post['ids'][0]) && !empty($post['ids'][1])) {

                $transaction = Yii::$app->db->beginTransaction();

                try {
                    $firstLog = DealPaymentLog::findOne(['id' => $post['ids'][0]]);
                    $secondLog = DealPaymentLog::findOne(['id' => $post['ids'][1]]);

                    # First log history
                    $logInHistoryFirst = new DealPaymentLogHistory();
                    $logInHistoryFirst->deal_payment_log_id = $firstLog->id;
                    $logInHistoryFirst->previous_cashier_id = $firstLog->payer;
                    $logInHistoryFirst->current_cashier_id = $secondLog->payer;

                    # Second log history
                    $logInHistorySecond = new DealPaymentLogHistory();
                    $logInHistorySecond->deal_payment_log_id = $secondLog->id;
                    $logInHistorySecond->previous_cashier_id = $secondLog->payer;
                    $logInHistorySecond->current_cashier_id = Yii::$app->user->identity->cashierOperator->cashier_id;

                    $firstLog->payer = $secondLog->payer;
                    $secondLog->payer = Yii::$app->user->identity->cashierOperator->cashier_id;

                    if ($firstLog->save() && $secondLog->save()) {
                        if ($logInHistoryFirst->save() && $logInHistorySecond->save()) {
                            $transaction->commit();

                            return true;
                        }
                    }
                } catch (\Exception $exception) {
                    $transaction->rollBack();
                    return false;
                }
            }

            return false;
        }
    }

    /**
     * Change the wrongly paid client.
     *
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionChangeWrongPaidDeal(Request $request) {
        if ($request->isAjax) {

            $transaction = Yii::$app->db->beginTransaction();

            try {

                # Take the deal to be changed.
                $wronglyPayedClient = DealPaymentLog::findOne(['id' => (int) $request->post('wrongPayedClient')]);

                # Get selected deal for check.
                $correctDeal = Deal::findOne($request->post('selectedDeal'));

                if (!empty($request->post('comment'))) {
                    $comment = $request->post('comment') . ' | ' . $wronglyPayedClient->deal->deal_number . '-ից տեղափոխվել է ' . $correctDeal->deal_number . ' - ' . Carbon::now()->format('d-m-Y H:i');
                } else {
                    $comment = $comment = $wronglyPayedClient->deal->deal_number . '-ից տեղափոխվել է ' . $correctDeal->deal_number . ' - ' . Carbon::now()->format('d-m-Y H:i');
                }

                # Transfer the wrong payment
                $wronglyPayedClient->deal_id = $request->post('selectedDeal');
                $wronglyPayedClient->comment = $comment;
                if ($wronglyPayedClient->save()) {

                    $disabledPrice = DisabledDay::disabledPrice();

                    if ($correctDeal->isDaily()) {
                        $correctDealClientBalance = new DailyPricing($correctDeal);

                        $condition = (bool) ($correctDealClientBalance->virtualBalance() - $correctDealClientBalance->currentMonthTotalPayed()) <= 0;
                    } else {
                        $correctDealClientBalance = new Pricing($correctDeal);

                        $condition = ($correctDealClientBalance->virtualBalance() - $correctDealClientBalance->currentMonthTotalPayed()) <= $disabledPrice;
                    }

                    if ($condition) {

                        if ($correctDeal->isDisabled() || $correctDeal->isNoInternet()) {
                            $correctDeal->setActiveStatus();
                        }

                        # Enable mikrotik for changed deal.
                        $enableMikrotik = new ManageMikrotik($correctDeal);
                        $enableMikrotik->createNewFirewall();
                    }

                    # Minchev balanc@ chstugvi statusner@ poxel@ sxal kashxati

                    $dealForDisable = Deal::findOne($request->post('wrongPayedDeal'));

                    if ($dealForDisable->isDaily()) {
                        $wronglyPayedClientBalance = new DailyPricing($dealForDisable);

                        $conditionForDisable = (bool) ($wronglyPayedClientBalance->virtualBalance() - $wronglyPayedClientBalance->currentMonthTotalPayed()) >= 0;
                    } else {
                        $wronglyPayedClientBalance = new Pricing($dealForDisable);

                        $conditionForDisable = (bool) ($wronglyPayedClientBalance->virtualBalance() - $wronglyPayedClientBalance->currentMonthTotalPayed()) >= $disabledPrice;
                    }

                    if ($conditionForDisable) {
                        $dealForDisable->setNoInternetStatus();

                        # Disable mikrotik for selected deal.
                        $disableMikrotik = new ManageMikrotik($dealForDisable);
                        $disableMikrotik->removeFirewall();
                    }

                    $correctDeal->save();
                    $dealForDisable->save();

                    Yii::$app->session->setFlash('success', 'Վճարումը փոփոխված է');
                    $transaction->commit();
                    return Json::encode(['status' => true]);
                }
            } catch (\Exception $exception) {
                $transaction->rollBack();
                return Json::encode(['status' => false]);
            }
        }
    }

    /**
     * Search payment list by deal_number.
     *
     * @param null $q
     * @param null $id
     * @return array
     */
    public function actionSearchDeal($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $result = [];

        $deal = Deal::find()
            ->select('id, deal_number')
            ->where(['LIKE', 'deal_number', $q])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        $result[] = ['id' => $deal->id, 'text' => $deal->deal_number];

        $out['results'] = $result;
        return $out;
    }

    /**
     * @return string
     */
    public function actionGetSelectedDealInfo() {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();

            $paymentLog = !empty($post['id']) ? DealPaymentLog::find()->where(['IN', 'id', $post['id']])->all() : [];

            return $this->renderAjax('partials/_payment_list_table', ['paymentLogs' => $paymentLog]);
        }
    }

    /**
     * @return string
     */
    public function actionGetSelectedDealPaymentInfo() {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();

            $paymentLog = !empty($post['id']) ? DealPaymentLog::find()->where(['deal_id' => $post['id']])->orderBy(['deal_id' => SORT_DESC])->one() : [];

            return $this->renderAjax('partials/_wrong_payment_change_table', ['paymentLog' => $paymentLog]);
        }
    }

    /**
     * @return string
     */
    public function actionGetSelectedDealTotalSum() {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();

            $paymentLog = !empty($post['id']) ? DealPaymentLog::find()->where(['IN', 'id', $post['id']])->sum('price') : [];

            return Json::encode(['total' => $paymentLog]);
        }
    }

    public function actionCheckPaymentReceivedStatus() {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();

            $paymentLog = DealPaymentLog::find()->where(['IN', 'id', $post['id']])->all();

            foreach ($paymentLog as $log) {
                if ($log->update_at) {
                    return Json::encode(['status' => false]);
                }
            }

            return Json::encode(['status' => true]);
        }
    }

    /**
     * @return array
     */
    public function actionRevertCashier() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();

            $paymentLog = DealPaymentLog::findOne($post['old_log_id']);
            $revertLogCashier = DealPaymentLog::findOne($post['secondCashierId']);
            $paydeal_id = $paymentLog->deal_id;
            $revDeal_id = $revertLogCashier->deal_id;
            $rev = (bool)$post['revertBallance'];
            if(!$rev){
                $newLog = new DealPaymentLog();
                if(($paymentLog->price - $revertLogCashier->price) > 0){
                    $newLog->attributes = $paymentLog->attributes;
                    $newLog->price =  $paymentLog->price - $revertLogCashier->price; // 3333 5555 5555
                    $paymentLog->price = $revertLogCashier->price;

                }else{
                    $newLog->attributes = $revertLogCashier->attributes;
                    $newLog->price = $revertLogCashier->price - $paymentLog->price;
                    $revertLogCashier->price = $paymentLog->price;

                }
                $newLog->comment = $post['comment'];
                $newLog->save();
            }

            $paymentLog->deal_id =  $revDeal_id;
            $revertLogCashier->deal_id =  $paydeal_id;

            $paymentLog->comment = $post['comment'];
            $revertLogCashier->comment = $post['comment'];




            if ($paymentLog->save() && $revertLogCashier->save()) {
                return ['status' => true, 'message' => 'Պահպանվել է'];
            } else {
                return ['status' => false, 'message' => 'Չի պահպանվել'];
            }
        }
    }

    /**
     * Send cash register receipt to cashier.
     *
     * @return bool|\yii\web\Response
     */
    public function actionCashRegisterReceiptCashier () {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();

            if (empty($post['selection'])) {
                Yii::$app->session->setFlash('danger', 'Նշել առնվազն մեկ վճարում');
                return false;
            }

            if (empty($post['cashier'])) {
                Yii::$app->session->setFlash('danger', 'Ընտրեք գանձապահ');
                return false;
            }

            foreach ($post['selection'] as $payLog) {

                $checkHdm = DealPaymentLog::findOne($payLog);

                if ($checkHdm->hdm == DealPaymentLog::HDM) {
                    Yii::$app->session->setFlash('danger', Yii::t('app', 'Ընտրեք այն վճարումները որոնց համար չեն տպվել ՀԴՄ կտրոն'));
                    return false;
                }

                $cashRegisterReceiptModel = new CashRegisterReceipt();
                $cashRegisterReceiptModel->payment_log_id = $payLog;
                $cashRegisterReceiptModel->cashier_id = $post['cashier'];
                $cashRegisterReceiptModel->created_by = Yii::$app->user->identity->cashierOperator->cashier_id;
                $cashRegisterReceiptModel->save();
            }

            $getCashierName = Cashier::find()
                ->select('name')
                ->where(['id' => $post['cashier']])
                ->one();

            Yii::$app->session->setFlash('success', "Վճարումները ուղարկվել են {$getCashierName->name}");
            return true;
        }

        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * Deletes an existing DealPaymentLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel(DealPaymentLog::class, $id)->delete();

        return $this->redirect(['index']);
    }
}
