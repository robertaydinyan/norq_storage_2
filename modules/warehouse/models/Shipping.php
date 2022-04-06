<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_shipping".
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $shipping_type
 * @property int $provider_warehouse_id
 * @property int $supplier_warehouse_id
 * @property int $partner_id
 */
class Shipping extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_shipping';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'shipping_type', 'status'], 'safe'],
            [['provider_warehouse_id', 'supplier_warehouse_id'], 'required'],
            [['provider_warehouse_id', 'supplier_warehouse_id', 'user_id','partner_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Ստեղծվել է',
            'shipping_type' => 'Տեղափոխման տեսակ',
            'provider_warehouse_id' => 'Առաքող պահեստ',
            'supplier_warehouse_id' => 'Ստացող պահեստ',
            'user_id' => 'Պետք է հաստատի',
            'status' => 'Կարգավիճակ',
            'partner_id' => 'Գործընկեր',
            'invoice' => 'Գործընկեր',
            'comment' => 'Գործընկեր',
            'request_id' => 'Գործընկեր',
            'document_type' => 'Գործընկեր',

        ];
    }
    public static function getType()
    {
        return ['Դուրս գրում'=>'Դուրս գրում', 'Տեղափոխման հայտ'=>'Տեղափոխման հայտ',
            'Տեղափոխում' => 'Տեղափոխում', 'Խոտանում' => 'Խոտանում', 'Վաճառք' => 'Վաճառք', ];
    }
    public static function getTypeByDeal()
    {
        return ['Տեղափոխում'=>'Տեղափոխում', 'Նվեր'=>'Նվեր', 'Նվեր ակցիա' => 'Նվեր ակցիա' , 'Վաճառք' => 'Վաճառք'];
    }
    public function getShippingRequests()
    {
        return $this->hasMany(ShippingRequest::class, ['shipping_id' => 'id']);
    }
    public function getToWarehouse()
    {
        return $this->hasOne(Warehouse::class, ['id' => 'supplier_warehouse_id']);
    }
    public function getFromWarehouse()
    {
        return $this->hasOne(Warehouse::class, ['id' => 'provider_warehouse_id']);
    }
}
