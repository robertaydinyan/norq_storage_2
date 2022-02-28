<?php

namespace app\components;

use app\modules\billing\models\DealPaymentLog;
use Yii;

/**
 * Class DailyPricing
 * @package app\components
 */
class DailyPricing
{

    /**
     * @var $model
     */
    private $model;

    /**
     * DailyPricing constructor.
     * @param $model
     */
    public function __construct($model) {
        $this->model = $model;
    }

    /**
     * Calculate deal tariff price with discount and electricity.
     *
     * @param bool $discount
     * @return int
     */
    public function totalDealAmount($discount = true) {
        $tariffPrice = ($this->model->tariff->inet_price ?: 0) + ($this->model->tariff->tv ? $this->model->tariff->tv->price : 0);
        return (int) $discount ? $tariffPrice - (($this->model->discount ?: 0) + ($this->model->electricity ?: 0)) : $tariffPrice;
    }

    /**
     * Sum of all paid ips
     *
     * @param bool $count
     * @return float|int
     */
    public function sumIPPrice($count = false) {
        return (int) $this->model->getDealIp()->count() > 0 ?
            !$count ? ($this->model->getDealIp()->count() * 1000) : $this->model->getDealIp()->count() : 0;
    }

    /**
     * @return bool|int|mixed|string|null
     */
    public function currentMonthTotalPayed() {
        $total = DealPaymentLog::find()->where(['deal_id' => $this->model->id])->sum('price');
        return !empty($total) ? $total : 0;
    }

    /**
     * @param bool $connectPrice
     * @return float|int
     */
    public function virtualBalance($connectPrice = true) {
        $monthPrice = $this->model->balance ? $this->model->balance->balance : $this->totalDealAmount();

        return $connectPrice ? $monthPrice + ($this->sumIPPrice() + $this->model->connect_price ?: 0) : $monthPrice;
    }

    /**
     * @return bool|float|int|mixed|string|null
     */
    public function disruptionPrice() {
        $penalty = $this->model->penalty ? floatval($this->model->penalty) : 0;
        $sale = $this->model->sale ? floatval($this->model->sale->price) : 0;
        return (int) ($this->totalDealAmount() - $sale) + ($this->sumIPPrice() + $this->model->connect_price) + $penalty - $this->currentMonthTotalPayed();
    }

    /**
     * @return float|int
     */
    public function monthlyPaymentNeed() {
        return $this->totalDealAmount() + $this->sumIPPrice();
    }

}