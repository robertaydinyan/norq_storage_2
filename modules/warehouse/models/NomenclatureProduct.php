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
 * @property string|null $expiration_date
 * @property int|null $is_vip
 * @property string|null $individual
 * @property int|null $qty_type_id
 * @property int|null $min_qty
 * @property int $group_id
 * @property string|null $expenditure_article
 * @property int|null $is_vat
 * @property string|null $manufacturer_name
 * @property string|null $other
 * @property string|null $technical_description
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
            [['production_date', 'expiration_date'], 'safe'],
            [['group_id', 'qty_type_id', 'is_vat', 'manufacturer', 'isDeleted'], 'integer'],
            [[
                'nomenclature_type',
                'vendor_code',
                'name',
                'series',
                'individual',
                'expenditure_article',
                'other',
                'ref',
                'technical_description',
                'comment'
            ], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vendor_code' => Yii::t('app', 'Vendor code'),
            'name' => Yii::t('app', 'Name'),
            'series' => Yii::t('app', 'Series'),
            'production_date' => Yii::t('app', 'Production date'),
            'expiration_date' => Yii::t('app', 'Expiration date'),
            'ref' => Yii::t('app', 'Ref Code'),
            'qty_type_id' => Yii::t('app', 'Quantity type'),
            'technical_description' => Yii::t('app', 'Technical Description'),
            'expenditure_article' => Yii::t('app', 'Expenditure Article'),
            'vat' => Yii::t('app', 'Vat'),
            'is_vat' => Yii::t('app', 'Vat'),
            'comment' => Yii::t('app', 'Comment'),
            'manufacturer_name' => Yii::t('app', 'Manufacturer'),
            'manufacturer' => Yii::t('app', 'Manufacturer'),
            'other' => Yii::t('app', 'Other'),
            'individual' => Yii::t('app', 'Individual'),
            'group_id' => Yii::t('app', 'Group'),
            'nomenclature_type' => Yii::t('app', 'Nomenclature Type'),
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabelsAll()
    {
        return [
            'id' => 'ID',
            'vendor_code' => 'Vendor code',
            'name' => 'Name',
            'series' => 'Series',
            'production_date' => 'Production date',
            'expiration_date' => 'Expiration date',
//            'daysCount' => 'Days count',
            'ref' => 'Ref Code',
            'qty_type' => 'Quantity type',
            'technical_description' => 'Technical Description',
            'expenditure_article_name' => 'Expenditure Article',
            'is_vat' => 'Vat',
            'comment' => 'Comment',
            'manufacturer' => 'Manufacturer',
            'other' => 'Other',
            'individual' => 'Individual',
            'group' => 'Group',
            'count' => 'Count',
            'barcode' => 'Barcodes',
            'nomenclature_type' => 'Nomenclature Type'
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
      public function findCountByNom($id)
    {
        if(intval($id)) {
            return Yii::$app->db->createCommand("SELECT SUM(count) as count_ FROM s_product WHERE nomenclature_product_id = $id")->queryOne()['count_'];
        } else {
            return 0;
        }
    }
    public function getManufacturerName() {
        return $this->hasOne(Manufacturer::class, ['id' => 'manufacturer']);
    }

    public static function saveBarcodes($barcodes, $barcodes_new, $id) {
        foreach ($barcodes_new as $i => $b) {
            if (!$b) continue;
            $barcode = new Barcode();
            $barcode->code = $b;
            $barcode->product_id = $id;
            $barcode->save(false);
        }
        foreach ($barcodes as $i => $b) {
            if (!$b[0]) {
                Barcode::deleteAll(['id' => $i]);
            } else {
                $barcode = Barcode::find()->where(['id' => $i])->one();
                $barcode->code = $b[0];
                $barcode->save();
            }
        }
    }

    public function getVatName() {
        return $this->hasOne(Vat::class, ['id' => 'is_vat']);
    }

    public function getExpArticle() {
        return $this->hasOne(ExpenditureArticle::class, ['id' => 'expenditure_article']);
    }

    public function getBarcodes() {
        $bs = Barcode::find()->where(['product_id' => $this->id])->all();
        $res = '';
        foreach ($bs as $b) {
            $res .= '<span>' . $b->code . '</span><br>';
        }

        return $res;
    }

    public function getNomenclatureTypeName() {
        return $this->hasOne(NomenclatureType::class, ['id' => 'nomenclature_type']);

    }
}