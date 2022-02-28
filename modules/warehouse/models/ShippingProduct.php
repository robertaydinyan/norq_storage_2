<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_shipping_product".
 *
 * @property int $id
 * @property string $created_at
 * @property int $shipping_id
 * @property int $product_id
 */
class ShippingProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_shipping_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'shipping_id', 'product_id'], 'required'],
            [['created_at'], 'safe'],
            [['shipping_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'shipping_id' => 'Shipping ID',
            'product_id' => 'Product ID',
            'count' => 'Քանակ',
            'nomenclature_product_id' => 'Ապրանքի Նոմենկլատուրա',
        ];
    }
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
    public function getShipping()
    {
        return $this->hasOne(Shipping::class, ['id' => 'shipping_id']);
    }

}
