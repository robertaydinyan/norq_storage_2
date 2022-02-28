<?php

namespace app\components;

use app\modules\fastnet\Traits\DealTrait;
use Carbon\Carbon;
use Yii;

class Pricing
{
use DealTrait;
    /**
     * @var $model
     */
    private $model;

    /**
     * Pricing constructor.
     * @param $model
     */
    public function __construct($model) {
        $this->model = $model;
    }

    /**
     * Sum of all paid ips
     *
     * @param bool $count
     * @return float|int
     */
    public function sumIPPrice($count = false) {
        return $this->model->getDealIp()->count() > 0 ?
               !$count ? ($this->model->getDealIp()->count() * 1000) : $this->model->getDealIp()->count() : 0;
    }

    /**
     * Calculate deal tariff price with discount and electricity.
     *
     * @param bool $discount
     * @return int
     */
    public function totalDealAmount($discount = true) {
        $tariffPrice = ($this->model->tariff->inet_price ?: 0) + ($this->model->tariff->tv ? $this->model->tariff->tv->price : 0);
        return $discount ? $tariffPrice - (($this->model->discount ?: 0) + ($this->model->electricity ?: 0)) : $tariffPrice;
    }

    /**
     * @param false $ending - For vacation finish.
     * @return array|float|int
     */
    public function vacationPrice($ending = false) {
        $helper = new Helper();

        if (!$ending) {
            return $helper->mathPriceMonth($this->totalDealAmount(), null, null, $this->model->vacation->data_start, $this->model->vacation->data_end, $this->model->connection_day);
        } else {
            if($this->model->vacation->data_start < date('Y-m-d H:i:s')) {
                return $helper->mathPriceMonth($this->totalDealAmount(), null, null, $this->model->vacation->data_start, date('Y-m-d H:i:s'), $this->model->connection_day);
            } else {
                return $helper->mathPriceMonth($this->totalDealAmount(), null, null, $this->model->vacation->data_start, $this->model->vacation->data_end, $this->model->connection_day);
            }
        }
    }

    /**
     * @return array|bool|float|int
     * @throws \yii\db\Exception
     */
    public function disruptionPrice() {
        $helper = new Helper();

        $monthTariff = !$this->model->start_deal ? (($this->model->tariff->inet_price ?: 0) + ($this->model->tariff->tv ? $this->model->tariff->tv->price : 0)) - ($this->model->discount ?: 0) - ($this->model->electricity ?: 0) : 0;


        if($this->model->isCompany() && !$this->model->start_deal){
            $old = $this->model->balance->balance;

        }elseif(!$this->model->isCompany() && !$this->model->start_deal){

           $old = ($this->model->balance ? $this->model->balance->balance - $monthTariff : 0);
        }else{

            $old = 0;
        }

        $balance = $helper->mathPriceMonth($this->totalDealAmount(), $this->model->connection_day, Carbon::now()->format('Y-m-d'));
        $totalPaid = ($balance + $this->sumIPPrice() + ($this->model->connect_price ?: 0) + ($this->model->penalty ?: 0)) - $this->currentMonthTotalPayed();
        return round($old + $totalPaid);
    }




    /**
     * Deal total amount with discount.
     *
     * @return float|int
     */
    public function discountDeal() {
        $sale = $this->model->sale ? floatval($this->model->sale->price) : 0;
        return $this->totalDealAmount() - $sale;
    }

    /**
     * @return bool|int
     * @throws \yii\db\Exception
     */
    public function currentMonthTotalPayed() {
        $total = Yii::$app->db->createCommand("SELECT SUM(price) as total FROM deal_payment_log WHERE  deal_id = {$this->model->id}")->queryOne();
        return isset($total['total']) ? $total['total'] : 0;
    }

    /**
     * @param bool $connect_ip
     * @param null $date
     * @param bool $vacation
     * @return float
     */
    public function virtualBalance($connect_ip = true, $date = null, $vacation = false)
    {
        $otherSerive = $connect_ip ? ((int)$this->model->connect_price ?? 0) + (int)$this->sumIPPrice() : 0;

        if ($this->model->balance && !$vacation) {
            $monthPrice = $this->model->balance->balance;
        } else {
            $date = $date ? date('Y-m-d', strtotime($date)) : date('Y-m-d');
            $helper = new Helper();
            $monthPrice = round($helper->mathPriceMonth($this->totalDealAmount(), $date));
            if ($this->model->isCompany()) {
                $monthPrice = round($helper->mathPriceMonth($this->totalDealAmount(), $this->model->connection_day, $date));

            }

        }

        $total = $monthPrice + $otherSerive;
        return $total;

    }

    /**
     * @param $newModel
     * @param false $change
     * @return array|float|int
     */
    public function oldBalance($newModel) {
        // Remove model parameter
        $helper = new Helper();

        $totalDealAmount = $this->totalDealAmount();

        $vacation = $this->model->outOfVacation ? $helper->mathPriceMonth($totalDealAmount, $this->model->outOfVacation->data_start, $this->model->outOfVacation->data_end) : 0;
        $oldModelMonthPrice = $helper->mathPriceMonth($totalDealAmount, $this->model->connection_day, $newModel->connection_day);

        return $oldModelMonthPrice - $vacation;
    }

    /**
     * Calculates in percent, the change between 2 numbers.
     * e.g from 1000 to 500 = 50%
     *
     * @param $oldNumber - The initial value
     * @param $newNumber - The value that changed
     * @return float|int
     */
    public function getPercentageChange($oldNumber, $newNumber) {
        $decreaseValue = $oldNumber - $newNumber;
        return ($decreaseValue / $oldNumber) * 100;
    }

}