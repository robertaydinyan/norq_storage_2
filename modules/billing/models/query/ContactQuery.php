<?php

namespace app\modules\billing\models\query;

class ContactQuery extends \yii\db\ActiveQuery
{

    /**
     * Select client with deal status "Завершени"
     * @return ContactQuery
     */
    public function dealFinished()
    {
        return $this->joinWith(['deal deal' => function ($query) {
            $query->joinWith(['status status']);
        }])
            ->onCondition(['status.status_type' => 2])
            ->where(['IS NOT', 'deal.id', NULL]);
    }

}