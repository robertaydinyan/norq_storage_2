<?php

namespace app\modules\warehouse\models;


use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "s_product".
 *
 * @property int $id
 * @property float|null $price
 * @property float|null $retail_price
 * @property int|null $supplier_id
 * @property string|null $comment
 * @property string|null $used
 * @property string $created_at
 * @property int $warehouse_id
 * @property int $shipping_id
 * @property int $nomenclature_product_id
 * @property int $status
 */
class ProductForRequest extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile[]
     */
    public $images;
    public static $groups = [];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_product_for_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'retail_price','shipping_id', 'min_qty', 'notice_if_move','status'], 'number'],
            [['created_at', 'warehouse_id', 'nomenclature_product_id'], 'required'],
            [['warehouse_id', 'nomenclature_product_id'], 'integer'],
            [['supplier_id','invoice' , 'comment', 'created_at'], 'string', 'max' => 255],
            [['images'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'images' => 'Արտադրանքի նկարները',
            'price' => 'Գին',
            'retail_price' => 'Մանրածախ գին',
            'supplier_id' => 'Մատակարար',
            'invoice' => 'Invoice',
            'comment' => 'Մեկնաբանություն',
            'count' => 'Քանակ',
            'created_at' => 'Ստեղծվել է /ժամը/',
            'warehouse_id' => 'Պահեստ',
            'status' => 'Պահեստ',
            'nomenclature_product_id' => 'Ապրանք',
        ];
    }
    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->images as $image) {
                $image->saveAs('uploads/' . $image->baseName . '.' . $image->extension);
            }
            return true;
        } else {
            return false;
        }
    }
    public function getWareHouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'warehouse_id']);
    }

 
    public function getNProduct()
    {
        return $this->hasOne(NomenclatureProduct::class, ['id' => 'nomenclature_product_id']);
    }

    public function getChilds($group_id){
        if($group_id){
           $groups_ = GroupProduct::find()->where(['group_id'=>$group_id])->all();
            array_push(self::$groups, $group_id);
           if(!empty($groups_)){
              foreach($groups_ as $group => $group_val){
                  array_push(self::$groups, $group_val['id']);
                  Product::getChilds($group_val['id']);
              }
           }
       } 
       return self::$groups;
    }
 
}
