<?php

namespace app\modules\crm\models;

use Yii;

/**
 * This is the model class for table "deal_address".
 *
 * @property int $id
 * @property int|null $deal_id
 * @property int|null $address_id
 */
class DealAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deal_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deal_id', 'address_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deal_id' => 'Deal ID',
            'address_id' => 'Address ID',
        ];
    }
    public function getAddress()
    {
        return $this->hasOne(ContactAdress::className(), ['id' => 'address_id']);
    }
}
