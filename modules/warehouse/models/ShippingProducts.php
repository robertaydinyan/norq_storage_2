<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_shipping_products".
 *
 * @property int $id
 * @property int|null $shipping_id
 * @property int|null $product_id
 * @property int|null $count
 * @property string $created_at
 * @property int|null $action_type
 * @property int|null currency
 */
class ShippingProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_shipping_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shipping_id','shipping_type','action_type', 'product_id', 'count', 'currency'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shipping_id' => 'Shipping ID',
            'product_id' => 'Product ID',
            'count' => 'Count',
            'created_at' => 'Created At',
            'currency' => 'Currency',
        ];
    }

    public function findByShip($id)
    {
        $lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
        if(intval($id)) {
            return Yii::$app->db->createCommand("SELECT s_nomenclature_product.*,s_qty_type.type_" . $lang . " as qty_type,s_shipping_products.*,s_product.mac_address as mac,s_product.price as bay_price FROM s_shipping_products  
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id            
                                                     LEFT JOIN s_nomenclature_product ON s_nomenclature_product.id = s_product.nomenclature_product_id
                                                     LEFT JOIN s_qty_type ON s_nomenclature_product.qty_type_id = s_qty_type.id 
                                                  WHERE s_shipping_products.shipping_id = $id")->queryAll();
        } else {
            return [];
        }
    }
    public function findByShipReq($id)
    {
        $lang = explode('-', \Yii::$app->language)[0] ?: 'hy';

        if(intval($id)) {
            return Yii::$app->db->createCommand("SELECT s_nomenclature_product.*,s_qty_type.type_ " . $lang . " as qty_type,s_product_for_request.* FROM s_product_for_request          
                                                     LEFT JOIN s_nomenclature_product ON s_nomenclature_product.id = s_product_for_request.nomenclature_product_id
                                                     LEFT JOIN s_qty_type ON s_nomenclature_product.qty_type_id = s_qty_type.id 
                                                  WHERE s_product_for_request.shipping_id = $id")->queryAll();
        } else {
            return [];
        }
    }
    public function findByProductId($id)
    {
        $lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
        if(intval($id)) {
            return Yii::$app->db->createCommand("SELECT s_nomenclature_product.*,s_qty_type.type_" . $lang . " as qty_type,s_shipping_products.*,s_product.mac_address as mac FROM s_shipping_products  
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id            
                                                     LEFT JOIN s_nomenclature_product ON s_nomenclature_product.id = s_product.nomenclature_product_id
                                                     LEFT JOIN s_qty_type ON s_nomenclature_product.qty_type_id = s_qty_type.id 
                                                  WHERE s_shipping_products.product_id = $id")->queryAll();
        } else {
            return [];
        }
    }
}
