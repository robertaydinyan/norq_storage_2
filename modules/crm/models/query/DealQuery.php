<?php

namespace app\modules\crm\models\query;

use app\modules\crm\models\Deal;
use yii\db\ActiveQuery;

class DealQuery extends ActiveQuery
{

    /**
     * @param $contact_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getDealStarterDealByClient($contact_id) {
        return Deal::find()->where(['contact_id' => $contact_id])->andWhere(['start_deal' => 1]);
    }

}