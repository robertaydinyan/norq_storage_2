<?php

namespace app\modules\fastnet\models;

use Yii;

/**
 * This is the model class for table "f_deal_sale".
 *
 * @property int $id
 * @property int|null $deal_id
 * @property string|null $month
 * @property float|null $price
 */
class DealSale extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_deal_sale';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deal_id'], 'integer'],
            [['month'], 'safe'],
            [['price'], 'number'],
        ];
    }

    public function getDeal(){
        return $this->hasOne(Deal::className(), ['id' => 'deal_id']);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deal_id' => 'Գործարքի համար',
            'month' => 'Ամիս',
            'price' => 'Զեղչ',
        ];
    }
}
