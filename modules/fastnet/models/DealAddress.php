<?php

namespace app\modules\fastnet\models;

use app\modules\crm\models\ContactAdress;
use Yii;

/**
 * This is the model class for table "f_deal_address".
 *
 * @property int $id
 * @property string|null $deal_number
 * @property int|null $contact_address_id
 */
class DealAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_deal_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contact_address_id'], 'integer'],
            [['deal_number'], 'string', 'max' => 255],
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
            'contact_address_id' => 'Contact Address ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress() {
        return $this->hasOne(ContactAdress::className(), ['id' => 'contact_address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeal() {
        return $this->hasOne(Deal::className(), ['deal_number' => 'deal_number']);
    }
}
