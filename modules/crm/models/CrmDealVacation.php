<?php

namespace app\modules\crm\models;

use Yii;
use app\modules\fastnet\models\Deal;

/**
 * This is the model class for table "crm_deal_vacation".
 *
 * @property int $id
 * @property int|null $deal_number
 * @property int|null $vacation_type_id
 * @property string|null $comment
 * @property string|null $data_start
 * @property string|null $data_end
 * @property int|null $status
 */
class CrmDealVacation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_deal_vacation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deal_number', 'vacation_type_id', 'status'], 'integer'],
            [['comment', 'data_start', 'data_end'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deal_number' => 'Deal Number',
            'vacation_type_id' => 'Vacation Type',
            'comment' => 'Comment',
            'data_start' => 'Data Start',
            'data_end' => 'Data End',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeal()
    {
        return $this->hasOne(Deal::className(), ['deal_number' => 'deal_number'])
            ->andOnCondition(['status' => Deal::VACATION]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealVacation()
    {
        return $this->hasOne(Deal::className(), ['deal_number' => 'deal_number']);
    }
}
