<?php

namespace app\modules\fastnet\models;

use Yii;

/**
 * This is the model class for table "f_deal_ip".
 *
 * @property int $id
 * @property int $deal_number
 * @property string|null $address
 * @property int|null $status ete 1 e anvchar e
 */
class DealIp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_deal_ip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deal_number'], 'required'],
            [['status'], 'integer'],
            ['status', 'default', 'value' => 0],
            [['address', 'deal_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deal_number' => 'Deal ID',
            'address' => 'Address',
            'status' => 'Status',
        ];
    }
}
