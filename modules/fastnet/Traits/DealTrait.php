<?php

namespace app\modules\fastnet\Traits;

use app\components\TimeHelper;
use app\modules\billing\models\DealPaymentLog;
use app\modules\billing\models\IpAddresses;
use app\modules\fastnet\models\Deal;
use Carbon\Carbon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;

trait DealTrait
{

    /**
     * @param bool $round
     * @return float|int
     * @throws \yii\db\Exception
     */
    public function balance($round = true)
    {
        $ip_count_price = $this->getDealIpPriceByCount($this->deal_number);
        $totalBalance = ($this->balance->balance + $ip_count_price + $this->connect_price) - DealPaymentLog::currentMonthTotal($this->id);

        return $round ? round($totalBalance) : $totalBalance;
    }

    /**
     * @return int
     */
    public function tariffAmount()
    {
        return ($this->tariff->inet_price ? $this->tariff->inet_price : 0) + ($this->tariff->tv ? $this->tariff->tv->price : 0);
    }

    /**
     * @return float
     */
    public function totalDealAmount()
    {
        $total_deal_amount  = $this->tariffAmount() - ($this->discount ? $this->discount : 0) - ($this->electricity ? $this->electricity : 0);
        return round($total_deal_amount);
    }

    /**
     * @return string
     */
    public function status()
    {
        $color = '';

        if ($this->isActive()) {
            $color = 'rgb(0, 176, 80)';
        } else if ($this->isVacation()) {
            $color = 'rgb(204, 204, 204)';
        } else if ($this->isDisabled()) {
            $color = 'orange';
        } else if ($this->isTermination()) {
            $color = 'rgb(255, 0, 0)';
        }

        return $color;
    }

    /**
     * @return array
     */
    public function contractEndingNotice()
    {
        $notice['color'] = '';
        $notice['text'] = '';

        $now = Carbon::now()->toDateString();
        $week = Carbon::now()->addWeek();
        $month = Carbon::now()->addMonth();

        if ($this->daily_finish_month < $month && $this->daily_month_end > $week) {
            $notice['color'] = 'rgb(0, 176, 80)';
            $notice['text'] = \Yii::t('app', 'Պայմանագրի ավարտին մնացել է մեկ ամիս կամ ավելի քիչ');
        } elseif ($this->daily_finish_month < $week && $this->daily_month_end !== $now && $this->daily_month_end > $now) {
            $notice['color'] = 'orange';
            $notice['text'] = \Yii::t('app', 'Պայմանագրի ավարտին մնացել է մեկ շաբաթ կամ ավելի քիչ');
        } elseif ($this->daily_finish_month == $now) {
            $notice['color'] = 'rgb(255, 0, 0)';
            $notice['text'] = \Yii::t('app', 'Պայմանագրի ավարտման ամսաթիվ');
        } elseif ($this->daily_finish_month < $now) {
            $notice['color'] = 'rgb(255, 0, 0)';
            $notice['text'] = \Yii::t('app', 'Պայմանագիրը ավարտվել է');
        }

        return $notice;
    }

    /**
     * @return mixed|null
     */
    public function customer()
    {
        if($this->crm_contact_id){
            return $this->crmContact;
        } else {
            return $this->crmCompany;
        }
    }

    /**
     * @return bool
     */
    public function isCompany()
    {
        if ($this->crm_company_id) {
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function passport()
    {
        if ($this->crm_contact_id) {
            return $this->crmContact->requisiteFiles;
        } else {
            return $this->crmCompany->requisiteFiles;
        }
    }

    /**
     * @param $status
     */
    public function relationIPAddressStatus($status)
    {
        foreach ($this->ips as $ipAddress) {
            $ipAddress->ipAddress->status = $status;
            $ipAddress->ipAddress->save();
        }
    }

    /**
     * @param $baseId
     * @return array
     */
    public function availableIPList($baseId)
    {
        $ipList = IpAddresses::find()
            ->andWhere(['base_id' => $baseId])
            ->joinWith('baseStationIp', function ($query) {
                $query->andWhere(['in', 'deal_number', $this->deal_number]);
            })
            ->orWhere(['status' => 1])
            ->asArray()
            ->all();

        return ArrayHelper::map($ipList, 'id', 'address');
    }

    /**
     * Set model attributes.
     */

    public function setActiveStatus()
    {
        return $this->status = self::ACTIVE;
    }

    public function setDisabledStatus()
    {
        return $this->status = self::DISABLED;
    }

    public function setVacationStatus()
    {
        return $this->status = self::VACATION;
    }

    public function setNoInternetStatus()
    {
        return $this->status = self::NO_INTERNET;
    }

    public function setSuspendedStatus()
    {
        return $this->status = self::SUSPENDED;
    }

    public function setClosedStatus()
    {
        return $this->status = self::CLOSED;
    }

    public function setTerminationStatus()
    {
        return $this->status = self::CONTRACT_TERMINATION;
    }

    /**
     * @param $isDaily
     * @return bool|int
     */
    public function setIsDaily($isDaily)
    {
        return $this->is_daily = isset($isDaily) ?: 0;
    }

    /**
     * @param $connectionDate
     * @return string|null
     */
    public function setConnectionDate($connectionDate = null)
    {
        if (empty($connectionDate)) {
            return $this->connection_day = Carbon::now()->toDateString();
        }

        return $this->connection_day = Carbon::parse($connectionDate)->toDateString();
    }

    /**
     * @param $connectPrice
     * @return int|null
     */
    public function setConnectPrice($connectPrice)
    {
        if (empty($connectPrice)) {
            return $this->connect_price = null;
        }

        return $this->connect_price = (int) $connectPrice;
    }

    /**
     * @param $speedDateStart
     * @return string|null
     */
    public function setSpeedDateStart($speedDateStart)
    {
        if (empty($speedDateStart)) {
            return $this->speed_date_start = null;
        }

        return $this->speed_date_start = Carbon::parse($speedDateStart)->toDateTimeString();
    }

    /**
     * @param $speedDateEnd
     * @return string|null
     */
    public function setSpeedDateEnd($speedDateEnd)
    {
        if (empty($speedDateEnd)) {
            return $this->speed_date_end = null;
        }

        return $this->speed_date_end = Carbon::parse($speedDateEnd)->toDateTimeString();
    }

    /**
     * @param $isWifi
     * @return int
     */
    public function setIsWifi($isWifi)
    {
        return $this->is_wifi = isset($isWifi) ? 1 : 0;
    }

    /**
     * @param $blacklist
     * @return int
     */
    public function setBlacklist($blacklist)
    {
        return $this->blacklist = isset($blacklist) ? Deal::BLACKLIST_WHITE : Deal::BLACKLIST_BLACK;
    }

    /**
     * @param $contactId
     * @return bool|null
     */
    public function setContact($contactId)
    {
        return $this->crm_contact_id = $contactId;
    }

    /**
     * @param $companyId
     * @return bool|null
     */
    public function setCompany($companyId)
    {
        return $this->crm_company_id = $companyId;
    }

    /**
     * @param $contractStart
     * @param null $isDaily
     * @return string|null
     */
    public function setContractStart($contractStart, $isDaily = null)
    {
        if (empty($contractStart)) {
            return $this->contract_start = null;
        }

        $condition = $isDaily ? isset($isDaily) : !empty($contractStart);

        if ($condition) {
            return $this->contract_start = Carbon::parse($contractStart)->toDateTimeString();
        }
    }

    /**
     * @param $contractEnd
     * @param null $isDaily
     * @return string|null
     */
    public function setContractEnd($contractEnd, $isDaily = null)
    {
        if (empty($contractEnd)) {
            return $this->contract_end = null;
        }

        $condition = $isDaily ? isset($isDaily) : !empty($contractEnd);

        if ($condition) {
            return $this->contract_end = Carbon::parse($contractEnd)->toDateTimeString();
        }
    }

    /**
     * @param $startDate
     * @return string|null
     */
    public function setStartDate($startDate)
    {
        if (empty($startDate)) {
            return $this->start_day = Carbon::now()->toDateString();
        }

        return $this->start_day = Carbon::parse($startDate)->toDateString();
    }

    /**
     * @param $dailyFinishMonth
     * @param null $isDaily
     * @return string|null
     */
    public function setDailyFinishMonth($dailyFinishMonth, $isDaily = null)
    {
        if (empty($dailyFinishMonth)) {
            return $this->daily_finish_month = null;
        }

        $condition = $isDaily ? isset($isDaily) : !empty($dailyFinishMonth);

        if ($condition) {
            return $this->daily_finish_month = Carbon::parse($dailyFinishMonth)->toDateString();
        }
    }

    /**
     * @return string|null
     */
    public function setDailyMonthEnd()
    {
        return $this->daily_month_end = Carbon::now()->addMonth()->toDateString();
    }

    /**
     * @param $dailyFinishMonth
     * @param null $isDaily
     * @return string|null
     */
    public function setMonth($dailyFinishMonth, $isDaily = null)
    {
        if (empty($dailyFinishMonth)) {
            return $this->month = null;
        }

        $condition = $isDaily ? isset($isDaily) : !empty($dailyFinishMonth);

        if ($condition) {
            return $this->month = TimeHelper::getMonthsBetweenDates(Carbon::now()->format('Y-m-d 00:00:00'), Carbon::parse($dailyFinishMonth)->format('Y-m-d 00:00:00'));
        }
    }

    /**
     * Check status attribute.
     */

    public function isActive()
    {
        return $this->status == self::ACTIVE;
    }

    public function isDisabled()
    {
        return $this->status == self::DISABLED;
    }

    public function isVacation()
    {
        return $this->status == self::VACATION;
    }

    public function isNoInternet()
    {
        return $this->status == self::NO_INTERNET;
    }

    public function isSuspended()
    {
        return $this->status == self::SUSPENDED;
    }

    /**
     * @return bool
     */
    public function isClosed()
    {
        return $this->status == self::CLOSED;
    }

    /**
     * @return bool
     */
    public function isTermination()
    {
        return $this->status == self::CONTRACT_TERMINATION;
    }

    /**
     * @return bool
     */
    public function isDaily()
    {
        return $this->is_daily == self::IS_DAILY;
    }

    /**
     * @return bool
     */
    public function isNotDaily()
    {
        return $this->is_daily == self::NOT_DAILY;
    }

    /**
     * @return string
     */
    public function formatedAddress($lastElement = false, $asString = false) {
        $addresses = [];

        if (!empty($this->addresses)) {
            foreach ($this->addresses as $key => $address) {
                $region = !empty($address->address->region->name) ? $address->address->region->name : '';

                $community = '';
                $city = '';
                $house = '';
                $apartment = '';

                if (!empty($address->address->community)) {
                    $community .= ', հ․ ' . $address->address->community->name;
                } else {
                    if (!empty($address->address->city)) {
                        if ($address->address->city->city_type_id == 1) {
                            $city .= ', ք․ ';
                        } elseif ($address->address->city->city_type_id == 3) {
                            $city .= ', գ․ ';
                        }

                        $city .= $address->address->city->name;
                    }
                }

                $street = !empty($address->address->fastStreet) ? ', փ․ ' . $address->address->fastStreet->name : '';

                if (!empty($address->address->house)) {
                    if (!empty($address->address->apartment)) {
                        $house .= ', շ․ ';
                    } else {
                        $house .= ', տ․ ';
                    }

                    $house .= $address->address->house;
                }

                if (!empty($address->address->apartment)) {
                    if ($address->address->house) {
                        $apartment .= ', բն․ ';
                    } else {
                        $apartment .= ', տ․ ';
                    }

                    $apartment .= $address->address->apartment;
                }

                $entrance = !empty($address->address->housing) && !empty($address->address->apartment) && !empty($address->address->house) ? ', մ․ ' . $address->address->housing : '';
                $addresses[] = $region . $community . $city . $street . $house . $entrance . $apartment;
            }
        }

        if ($lastElement) {
            return end($addresses);
        } elseif ($asString) {
            return $addresses;
        } else {
            return Html::tag('div', StringHelper::truncate(implode(",<br>", $addresses), 100), ['title' => implode(",", $addresses), 'data-toggle' => 'tooltip', 'data-placement' => 'top']);
        }
    }
}