<?php

namespace app\modules\fastnet\models\query;

use app\modules\fastnet\models\Deal;
use yii\db\ActiveQuery;

class DealQuery extends ActiveQuery
{

    /**
     * @return DealQuery
     */
    public function isDaily() {
        return $this->andWhere(['is_daily' => true]);
    }

    /**
     * @return DealQuery
     */
    public function isNotDaily() {
        return $this->andWhere(['is_daily' => false]);
    }

    /**
     * @return DealQuery
     */
    public function isNotProvider() {
        return $this->andWhere(['is_provider' => false]);
    }
    /**
     * Active deal - ex. Deal::find()->active()->one();
     *
     * @return DealQuery
     */
    public function active() {
        return $this->andWhere(['status' => Deal::ACTIVE]);
    }

    /**
     * @return DealQuery
     */
    public function vacation() {
        return $this->andWhere(['status' => Deal::VACATION]);
    }

    /**
     * @return DealQuery
     */
    public function terminated() {
        return $this->andWhere(['status' => Deal::CONTRACT_TERMINATION]);
    }

    /**
     * @return DealQuery
     */
    public function suspended() {
        return $this->andWhere(['status' => Deal::SUSPENDED]);
    }

    /**
     * @return DealQuery
     */
    public function disabled() {
        return $this->andWhere(['status' => Deal::DISABLED]);
    }

    /**
     * @return DealQuery
     */
    public function closed() {
        return $this->andWhere(['status' => Deal::CLOSED]);
    }

    /**
     * @return DealQuery
     */
    public function noInternet() {
        return $this->andWhere(['status' => Deal::NO_INTERNET]);
    }

    /**
     * ex. Deal::find()->statusHas([Deal::ACTIVE, Deal::VACATION])->all();
     *
     * @param $status
     * @return DealQuery
     */
    public function statusHas($status) {
        return $this->andWhere(['IN', 'status', $status]);
    }

    /**
     * @return DealQuery
     */
    public function blacklisted() {
        return $this->andWhere(['blacklist' => true]);
    }

    /**
     * @return DealQuery
     */
    public function notBlacklisted() {
        return $this->andWhere(['f_deal.blacklist' => false]);
    }

    /**
     * @return DealQuery
     */
    public function dealIsActive() {
        return $this->andWhere(['f_deal.is_active' => true]);
    }

    /**
     * @return DealQuery
     */
    public function dealInactive() {
        return $this->andWhere(['f_deal.is_active' => false]);
    }

    /**
     * @return DealQuery
     */
    public function dealNumberIs($dealNumber) {
        return $this->andWhere(['f_deal.deal_number' => $dealNumber]);
    }

    /**
     * @param null $companyId
     * @return DealQuery
     */
    public function company($companyId = null) {
        return !$companyId ? $this->andWhere(['IS NOT', 'f_deal.crm_company_id', null])
            : $this->andWhere(['f_deal.crm_company_id' => $companyId]);
    }

    /**
     * @param null $contactId
     * @return DealQuery
     */
    public function contact($contactId = null) {
        return !$contactId ? $this->andWhere(['IS NOT', 'f_deal.crm_contact_id', null])
            : $this->andWhere(['f_deal.crm_contact_id' => $contactId]);
    }
}