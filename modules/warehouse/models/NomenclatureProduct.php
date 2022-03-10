<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_nomenclature_product".
 *
 * @property int $id
 * @property string|null $vendor_code
 * @property string $name
 * @property string|null $group
 * @property string|null $production_date
 * @property int|null $is_vip
 * @property string|null $individual
 * @property int|null $qty_type_id
 * @property int|null $min_qty
 * @property int|null $qty_for_notice
 * @property int $group_id
 */
class NomenclatureProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_nomenclature_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id'], 'required'],
            [['production_date'], 'safe'],
            [['group_id', 'qty_type_id','qty_for_notice','min_qty'], 'integer'],
            [['vendor_code_hy', 'vendor_code_ru', 'vendor_code_en', 'name_hy', 'name_en', 'name_ru', 'group', 'individual','img'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vendor_code_hy' => Yii::t('app', 'Vendor code(Armenian)'),
            'name_hy' => Yii::t('app', 'Name(Armenian)'),
            'vendor_code_ru' => Yii::t('app', 'Vendor code(Russian)'),
            'name_ru' => Yii::t('app', 'Name(Russian)'),
            'vendor_code_en' => Yii::t('app', 'Vendor code(English)'),
            'name_en' => Yii::t('app', 'Name(English)'),
            'production_date' => Yii::t('app', 'Production date'),
            'individual' => Yii::t('app', 'Individual'),
            'min_qty' => Yii::t('app', 'Min Quantity'),
            'qty_for_notice' => Yii::t('app', 'Quantity required for approval'),
            'is_vip' => 'Vip',
            'qty_type_id' => Yii::t('app', 'Quantity type'),
            'group_id' => Yii::t('app', 'Group'),
        ];
    }
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['nomenclature_product_id' => 'id']);
    }
    public function getShippingRequests()
    {
        return $this->hasMany(ShippingRequest::class, ['nomenclature_product_id' => 'id']);
    }
    public function getGroupProduct()
    {
        return $this->hasOne(GroupProduct::class, ['id' => 'group_id']);
    }
    public function getQtyType()
    {
        return $this->hasOne(QtyType::class, ['id' => 'qty_type_id']);
    }
    public function findWithInfo($id)
    {
        if(intval($id)) {
            return Yii::$app->db->createCommand("SELECT s_nomenclature_product.*,s_qty_type.type as qty_type FROM s_nomenclature_product 
                                                  LEFT JOIN s_qty_type ON s_nomenclature_product.qty_type_id = s_qty_type.id 
                                                  WHERE s_nomenclature_product.id = $id")->queryOne();
        } else {
            return [];
        }
    }
    public function findCountByGroup($id)
    {
        if(intval($id)) {
            return Yii::$app->db->createCommand("SELECT count(id) as count_ FROM s_nomenclature_product WHERE group_id = $id")->queryOne()['count_'];
        } else {
            return 0;
        }
    }

}
