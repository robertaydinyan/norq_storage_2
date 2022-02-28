<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_product_shipping_log".
 *
 * @property int $id
 * @property string|null $from_
 * @property string|null $mac_address
 * @property string|null $to_
 * @property int|null $shipping_type
 * @property int|null $request_id
 * @property string $date_create
 */
class ProductShippingLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_product_shipping_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shipping_type', 'request_id'], 'integer'],
            [['date_create'], 'safe'],
            [['from_', 'mac_address', 'to_'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_' => 'From',
            'mac_address' => 'Mac Address',
            'to_' => 'To',
            'shipping_type' => 'Shipping Type',
            'request_id' => 'Request ID',
            'date_create' => 'Date Create',
        ];
    }
}
