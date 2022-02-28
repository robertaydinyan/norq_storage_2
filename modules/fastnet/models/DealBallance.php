<?php

namespace app\modules\fastnet\models;

use Yii;

/**
 * This is the model class for table "f_deal_ballance".
 *
 * @property string|null $deal_number
 * @property int|null $deal_id
 * @property float|null $balance
 * @property string|null $date
 */
class DealBallance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_deal_ballance';
    }



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['balance'], 'number'],
            [['date', 'deal_id'], 'safe'],
            [['deal_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'deal_number' => 'Deal Number',
            'balance' => 'Balance',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeal() {
        return $this->hasMany(Deal::className(), ['deal_number' => 'deal_number']);
    }

}