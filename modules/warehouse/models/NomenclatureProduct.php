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
            [['name', 'group_id'], 'required'],
            [['production_date'], 'safe'],
            [['group_id', 'qty_type_id','qty_for_notice','min_qty'], 'integer'],
            [['vendor_code', 'name', 'group', 'individual','img'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vendor_code' => 'Լրիվ անուն',
            'name' => 'Անուն',
            'production_date' => 'Արտադրության ամսաթիվը',
            'individual' => 'Անհատական',
            'min_qty' => 'Մինիմալ քանակ',
            'qty_for_notice' => 'Հաստատում պահանջող քանակ',
            'is_vip' => 'Vip',
            'qty_type_id' => 'Քանակի տեսակ',
            'group_id' => 'Խումբ',
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
