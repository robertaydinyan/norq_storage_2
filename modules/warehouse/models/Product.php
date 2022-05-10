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
 * @property string|null $mac_address
 * @property string|null $comment
 * @property string|null $used
 * @property string $created_at
 * @property int $warehouse_id
 * @property int $shipping_id
 * @property int $nomenclature_product_id
 * @property int $status
 * @property int $article
 * @property int $currency
 * @property int $qty_type
 * @property int $manufacturer
 * @property int $not_is_vat_price
 * @property int $group_id
 */


class Product extends \yii\db\ActiveRecord {
    /**
     * @var UploadedFile[]
     */
    public $images;
    public static $groups = [];
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 's_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['price', 'retail_price', 'shipping_id', 'status', 'currency'], 'number'],
            [['created_at', 'warehouse_id', 'nomenclature_product_id', 'product_name'], 'required'],
            [['warehouse_id', 'nomenclature_product_id','group_id','qty_type','not_is_vat_price','manufacturer','isDeleted'], 'integer'],
            [['supplier_id', 'mac_address', 'invoice', 'comment', 'created_at', 'product_name', 'article'], 'string', 'max' => 255],
            [['images'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'images' => 'Արտադրանքի նկարները',
            'price' => Yii::t('app', 'Արժեքը'),
            'currency' => Yii::t('app', 'Currency'),
            'retail_price' => 'Մանրածախ գին',
            'supplier_id' => Yii::t('app', 'Supplier'),
            'mac_address' => 'Mac հասցե',
            'product_name' => Yii::t('app', 'Product name'),
            'invoice' => 'Invoice',
            'comment' => Yii::t('app', 'Comment'),
            'count' => Yii::t('app', 'Count'),
            'created_at' => Yii::t('app', 'Created'),
            'warehouse_id' => Yii::t('app', 'Warehouse'),
            'status' => Yii::t('app', 'Status'),
            'nomenclature_product_id' => Yii::t('app', 'Nomenclature'),
            'article' => Yii::t('app', 'Article'),
            'qty_type' => Yii::t('app', 'Չափման միավոր'),
            'manufacturer' => Yii::t('app', 'Արտադրող'),
            'not_is_vat_price' => Yii::t('app', 'Արժեքը առանց ՍԱՀ'),
            'group_id' => Yii::t('app', 'Խումբ'),
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabelsAll($type) {
        if ($type == 1) {
            return [
                'id' => 'ID',
                'product_name' => 'Product Name',
                'WarehouseName' => 'Warehouse name',
                'NomenclatureName' => 'Nomenclature',
                'ProductPicture' => 'Product Picture',
                'Quantity' => 'Quantity',
                'qty_type' => 'qty_type',
                'Individual' => 'Individual',
                'article' => 'article',
                'barcodes' => 'barcodes',
                'manufacturer' => Yii::t('app', 'Արտադրող'),
                'not_is_vat_price' => Yii::t('app', 'Արժեքը առանց ՍԱՀ'),
                'group_id' => Yii::t('app', 'Խումբ'),

            ];
        } else if ($type == 2) {
            return [
                'id' => 'id',
                'product_name' => 'Product Name',
                'WarehouseName' => 'Warehouse name',
                'NomenclatureName' => 'Nomenclature',
                'ProductPicture' => 'Product Picture',
                'price' => 'Price',
                'currency' => 'Currency',
                'comment' => 'Comment',
                'created' => 'Created',
                'invoice' => 'invoice',
                'article' => 'article',
                'manufacturer' => Yii::t('app', 'Արտադրող'),
                'not_is_vat_price' => Yii::t('app', 'Արժեքը առանց ՍԱՀ'),
                'group_id' => Yii::t('app', 'Խումբ'),
            ];
        }

        return [];
    }
    public function upload() {
        if ($this->validate()) {
            foreach ($this->images as $image) {
                $image->saveAs('uploads/' . $image->baseName . '.' . $image->extension);
            }
            return true;
        }
        else {
            return false;
        }
    }

    public function getCurrencyData() {
        return $this->hasOne(Currency::class, ['id' => 'currency']);
    }

     public function MoveData($data, $nomiclature, $warehouse) {
        $end = date('Y-m-d', strtotime($data['to_created_at']));
        $start = date('Y-m-d', strtotime($data['from_created_at']));
        $warehouse_id = intval($data['supplier_warehouse_id']);

        if (!$warehouse_id) {
            $opening = intval(Yii::$app
                ->db
                ->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE   s_product.nomenclature_product_id = $nomiclature AND s_shipping.supplier_warehouse_id = $warehouse   AND s_shipping.shipping_type IN(2,6,7)  AND `s_shipping_products`.`created_at` < '$start'")->queryOne() ['pcount']);
            $opening_ = intval(Yii::$app
                ->db
                ->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE   s_product.nomenclature_product_id = $nomiclature AND s_shipping.provider_warehouse_id = $warehouse   AND s_shipping.shipping_type IN(8,9,7,10)  AND `s_shipping_products`.`created_at` < '$start'")->queryOne() ['pcount']);
            $opening = $opening - $opening_;
            $closing = intval(Yii::$app
                ->db
                ->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE   s_product.nomenclature_product_id = $nomiclature AND s_shipping.supplier_warehouse_id = $warehouse   AND s_shipping.shipping_type IN(2,6,7)  AND `s_shipping_products`.`created_at` <= '$end'")->queryOne() ['pcount']);

            $closing_ = intval(Yii::$app
                ->db
                ->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE   s_product.nomenclature_product_id = $nomiclature AND s_shipping.provider_warehouse_id = $warehouse   AND s_shipping.shipping_type IN(8,9,7,10)  AND `s_shipping_products`.`created_at` <= '$end'")->queryOne() ['pcount']);

            $closing = $closing - $closing_;
       
            $sell_in = intval(Yii::$app
                ->db
                ->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE   s_product.nomenclature_product_id = $nomiclature AND s_shipping.supplier_warehouse_id = $warehouse   AND s_shipping.shipping_type IN(2,6,7) AND  `s_shipping_products`.`created_at` >= '$start' AND `s_shipping_products`.`created_at` <= '$end'")->queryOne() ['pcount']);

            $sell_out = intval(Yii::$app
                ->db
                ->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id 
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE  s_product.nomenclature_product_id = $nomiclature AND s_shipping.provider_warehouse_id = $warehouse  AND s_shipping.shipping_type IN(8,9,7,10) AND  `s_shipping_products`.`created_at` >= '$start' AND `s_shipping_products`.`created_at` <= '$end'")->queryOne() ['pcount']);


        }
        else {
             $opening = intval(Yii::$app
                ->db
                ->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE   s_product.nomenclature_product_id = $nomiclature AND s_shipping.supplier_warehouse_id = $warehouse_id   AND s_shipping.shipping_type IN(2,6,7)  AND `s_shipping_products`.`created_at` < '$start'")->queryOne() ['pcount']);
            $opening_ = intval(Yii::$app
                ->db
                ->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE   s_product.nomenclature_product_id = $nomiclature AND s_shipping.provider_warehouse_id = $warehouse_id   AND s_shipping.shipping_type IN(8,9,7,10)  AND `s_shipping_products`.`created_at` < '$start'")->queryOne() ['pcount']);
            $opening = $opening - $opening_;

            $closing = intval(Yii::$app
                ->db
                ->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE   s_product.nomenclature_product_id = $nomiclature AND s_shipping.supplier_warehouse_id = $warehouse_id   AND s_shipping.shipping_type IN(2,6,7)  AND `s_shipping_products`.`created_at` < '$end'")->queryOne() ['pcount']);
          
            $closing_ = intval(Yii::$app
                ->db
                ->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE   s_product.nomenclature_product_id = $nomiclature AND s_shipping.provider_warehouse_id = $warehouse_id   AND s_shipping.shipping_type IN(8,9,7,10)  AND `s_shipping_products`.`created_at` < '$end'")->queryOne() ['pcount']);

            $closing = $closing - $closing_;
            $sell_in = intval(Yii::$app
                ->db
                ->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE   s_product.nomenclature_product_id = $nomiclature AND s_shipping.supplier_warehouse_id = $warehouse AND s_shipping.supplier_warehouse_id = $warehouse_id   AND s_shipping.shipping_type IN(2,6,7) AND  `s_shipping_products`.`created_at` >= '$start' AND `s_shipping_products`.`created_at` <= '$end'")->queryOne() ['pcount']);

            $sell_out = intval(Yii::$app
                ->db
                ->createCommand("SELECT SUM(s_shipping_products.count) as pcount FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id 
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE  s_product.nomenclature_product_id = $nomiclature  AND s_shipping.provider_warehouse_id = $warehouse_id  AND s_shipping.shipping_type IN(8,9,7,10) AND  `s_shipping_products`.`created_at` >= '$start' AND `s_shipping_products`.`created_at` <= '$end'")->queryOne() ['pcount']);
           
        }
        return ['closing' => $closing, 'sell_in' => $sell_in, 'sell_out' => $sell_out, 'opening' => $opening];
    }

    public static function findByData($data) {
        $sql = '';

        if ($data["virtual_type"]) {
            if (empty($sql)) {
                $sql = 'WHERE `s_warehouse`.`group_id` =' . intval($data["virtual_type"]);
            }
            else {
                $sql .= ' AND `s_warehouse`.`group_id` =' . intval($data["virtual_type"]);
            }
        }
       
        if ($_GET["search"]) {
            if (empty($sql)) {
                $sql = 'WHERE (`s_nomenclature_product`.`name` LIKE "%' .$_GET["search"].'%" OR `s_nomenclature_product`.`name` LIKE "%' .$_GET["search"].'%" OR `s_nomenclature_product`.`name` LIKE "%' .$_GET["search"].'%")';
            }
            else {
                $sql .= ' AND (`s_nomenclature_product`.`name` LIKE "%' .$_GET["search"].'%" OR `s_nomenclature_product`.`name` LIKE "%' .$_GET["search"].'%" OR `s_nomenclature_product`.`name` LIKE "%' .$_GET["search"].'%")';
            }
        }
        if ($data["warehouse_type"]) {
            if (empty($sql)) {
                $sql = 'WHERE `s_warehouse`.`type` =' . intval($data["warehouse_type"]);
            }
            else {
                $sql .= ' AND `s_warehouse`.`type` =' . intval($data["warehouse_type"]);
            }
        }
        if ($data["supplier_warehouse_id"]) {
            if (empty($sql)) {
                $sql = 'WHERE `s_product`.`warehouse_id` =' . $data["supplier_warehouse_id"];
            }
            else {
                $sql .= ' AND `s_product`.`warehouse_id` =' . $data["supplier_warehouse_id"];
            }
        }

        if (!$data["serias"] && $data['nomiclature_id']) {
            $serias = substr($data["serias"], 0, -1);

            if (empty($sql)) {
                $sql = 'WHERE `s_product`.`nomenclature_product_id` = ' . $data['nomiclature_id'];
            }
            else {
                $sql .= ' AND `s_product`.`nomenclature_product_id` = ' . $data['nomiclature_id'];
            }
        }
        if (!$data["serias"] && !$data['nomiclature_id'] && $data['group']) {

            $grups__ = Product::getChilds($data['group']);
            $group_string = implode(',', $grups__);
            if (empty($sql)) {
                $sql = 'WHERE `s_nomenclature_product`.`group_id` IN( ' . $group_string . ') ';
            }
            else {
                $sql .= ' AND `s_nomenclature_product`.`group_id` IN( ' . $group_string . ') ';
            }
        }

        if (empty($sql)) {
            $sql .= ' WHERE s_product.status != 0 AND s_product.count > 0 ';
        }
        else {
            $sql .= ' AND s_product.status != 0 AND s_product.count > 0 ';
        }
        if (!isset($data['show-ware'])) {
            $group_by = 'GROUP BY s_product.nomenclature_product_id';
        }
        else {
            $group_by = 'GROUP BY s_product.warehouse_id,s_product.nomenclature_product_id';
        }
        if (isset($data['show-series'])) {
            $group_by = 'GROUP BY s_product.warehouse_id,s_product.id'; 
        }
        // $group_by = 'GROUP BY s_product.nomenclature_product_id,s_product.warehouse_id ';
        
        return Yii::$app
            ->db
            ->createCommand("SELECT SUM(s_product.count) as pcount,SUM(s_product.price * s_product.count) as pprice,AVG(s_product.price) as avgprice,s_warehouse.name as wname,s_warehouse.id as wid,s_nomenclature_product.*,s_qty_type.type as qty_type,s_product.*,s_product.mac_address as mac FROM s_product            
                                                     LEFT JOIN s_nomenclature_product ON s_nomenclature_product.id = s_product.nomenclature_product_id
                                                     LEFT JOIN s_qty_type ON s_nomenclature_product.qty_type_id = s_qty_type.id 
                                                     LEFT JOIN s_warehouse ON s_warehouse.id = s_product.warehouse_id 
                                                   $sql  $group_by ORDER BY s_product.nomenclature_product_id")->queryAll();
            
    }

    public function getNProduct() {
        return $this->hasOne(NomenclatureProduct::class , ['id' => 'nomenclature_product_id']);
    }


    public function getWarehouseProducts($id) {
        if ($id) {
            $whProductsCount = Yii::$app
                ->db
                ->createCommand("SELECT COUNT(`s_product`.id) as total_count FROM `s_product` LEFT JOIN `s_nomenclature_product` ON `s_product`.`nomenclature_product_id` = `s_nomenclature_product`.`id` LEFT JOIN `s_qty_type` ON `s_nomenclature_product`.`qty_type_id` = `s_qty_type`.`id` LEFT JOIN `s_warehouse` ON `s_product`.`warehouse_id` = `s_warehouse`.`id` WHERE `warehouse_id`=$id AND `status`=1 AND s_product.count>0 GROUP BY `nomenclature_product_id`, `warehouse_id` ")->queryAll();
            if (!isset($_GET['page'])) {
                $page = 1;
            }
            else {
                $page = intval($_GET['page']);
            }
            $results_per_page = 10;
            $page_first_result = ($page - 1) * $results_per_page;
            $number_of_page = ceil(count($whProductsCount) / $results_per_page);
            $whProducts = Yii::$app
                ->db
                ->createCommand("SELECT s_warehouse.name as wname, s_nomenclature_product.id as nid,s_qty_type.type as qtype,s_nomenclature_product.individual,s_nomenclature_product.name as nomeclature_name,s_warehouse.id,s_warehouse.type,nomenclature_product_id, sum(count) AS `count_n_product` FROM `s_product` LEFT JOIN `s_nomenclature_product` ON `s_product`.`nomenclature_product_id` = `s_nomenclature_product`.`id` LEFT JOIN `s_qty_type` ON `s_nomenclature_product`.`qty_type_id` = `s_qty_type`.`id` LEFT JOIN `s_warehouse` ON `s_product`.`warehouse_id` = `s_warehouse`.`id` WHERE `warehouse_id`=$id AND  `status`=1 AND s_product.count>0 GROUP BY `nomenclature_product_id`, `warehouse_id` ORDER BY `count_n_product` LIMIT " . $page_first_result . ',' . $results_per_page)->queryAll();
            return ['result' => $whProducts, 'params' => $params, 'total' => $number_of_page];
        }
        else {
            return [];
        }
    }

    public function getGroupProducts($group_id = null) {
        $sql = '';
        if ($group_id) {
            $sql = 'AND s_group_product.id = ' . $group_id;
        }
        $whProductsCount = Yii::$app
            ->db
            ->createCommand("SELECT COUNT(`s_product`.`id`) as total_count FROM `s_product` LEFT JOIN `s_nomenclature_product` ON `s_nomenclature_product`.`id`= `s_product`.`nomenclature_product_id` LEFT JOIN `s_group_product` ON `s_group_product`.`id`= `s_nomenclature_product`.`group_id` LEFT JOIN `s_warehouse` ON `s_warehouse`.`id`= `s_product`.`warehouse_id` LEFT JOIN `s_suppliers_list` ON `s_suppliers_list`.`id`= `s_product`.`supplier_id` LEFT JOIN `s_warehouse_types` ON `s_warehouse`.`type`= `s_warehouse_types`.`id` WHERE (`s_product`.`status`=1) AND (s_product.count > 0) $sql ")->queryOne();
        if (!isset($_GET['page'])) {
            $page = 1;
        }
        else {
            $page = intval($_GET['page']);
        }
        $results_per_page = 50;
        $page_first_result = ($page - 1) * $results_per_page;

        $number_of_page = ceil(intval($whProductsCount['total_count']) / $results_per_page);
        $whProducts = Yii::$app
            ->db
            ->createCommand("SELECT `s_product`.`id`, `s_product`.`price`, `s_product`.`retail_price`, `s_suppliers_list`.`name` AS `supplier_name`, `s_product`.`mac_address`, `s_product`.`comment`, `s_product`.`count`, `s_product`.`created_at`, `s_nomenclature_product`.`name` AS `n_product_name`, `s_nomenclature_product`.`production_date` AS `n_product_production_date`, `s_nomenclature_product`.`individual` AS `n_product_individual`, `s_nomenclature_product`.`qty_type_id` AS `n_product_qty_type`, `s_group_product`.`name` AS `group_name`, `s_group_product`.`id` AS `group_id`, `s_warehouse_types`.`name` AS `warehouse_type` FROM `s_product` LEFT JOIN `s_nomenclature_product` ON `s_nomenclature_product`.`id`= `s_product`.`nomenclature_product_id` LEFT JOIN `s_group_product` ON `s_group_product`.`id`= `s_nomenclature_product`.`group_id` LEFT JOIN `s_warehouse` ON `s_warehouse`.`id`= `s_product`.`warehouse_id` LEFT JOIN `s_suppliers_list` ON `s_suppliers_list`.`id`= `s_product`.`supplier_id` LEFT JOIN `s_warehouse_types` ON `s_warehouse`.`type`= `s_warehouse_types`.`id` WHERE  (`s_product`.`status`=1) AND (s_product.count > 0) $sql LIMIT " . $page_first_result . ',' . $results_per_page)->queryAll();

        return ['result' => $whProducts, 'total' => $number_of_page];
    }

    public function getChilds($group_id) {
        if ($group_id) {
            $groups_ = GroupProduct::find()->where(['group_id' => $group_id])->all();
            array_push(self::$groups, $group_id);
            if (!empty($groups_)) {
                foreach ($groups_ as $group => $group_val) {
                    array_push(self::$groups, $group_val['id']);
                    Product::getChilds($group_val['id']);
                }
            }
        }
        return self::$groups;
    }
    public function findForNotice() {
        return Yii::$app
            ->db
            ->createCommand("SELECT SUM(s_product.count) as pcount,s_nomenclature_product.min_qty as minqty,s_nomenclature_product.*,s_product.*,s_qty_type.type as qty_type
                                             FROM s_product            
                                              LEFT JOIN s_nomenclature_product ON s_nomenclature_product.id = s_product.nomenclature_product_id
                                               LEFT JOIN s_qty_type ON s_nomenclature_product.qty_type_id = s_qty_type.id 
                                               WHERE s_product.warehouse_id = 20 AND s_nomenclature_product.min_qty>0 AND s_product.count > 0 GROUP BY s_product.nomenclature_product_id 
                                              ")
            ->queryAll();
    }

    public function getWarehouse() {
        return $this->hasOne(Warehouse::class , ['id' => 'warehouse_id']);
    }

    public function getNomenclatureProduct() {
        return $this->hasOne(NomenclatureProduct::class, ['id' => 'nomenclature_product_id']);
    }
     public function findByOpening($data){
        $end = date('Y-m-d', strtotime($data['to_created_at']));
        $start = date('Y-m-d', strtotime($data['from_created_at']));
        $warehouse_id = intval($data['supplier_warehouse_id']);
        $nomeclature_id = intval($data['nomeclature_id']);
        $warehouse = intval($data['wid']);

         if (!$warehouse_id) {
            $wSql = "";
         } else {
            $wSql = "AND s_shipping.supplier_warehouse_id = $warehouse_id";
         }
         $opening_ = Yii::$app
                ->db
                ->createCommand("SELECT s_product.mac_address FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE  s_product.nomenclature_product_id = $nomeclature_id AND s_shipping.provider_warehouse_id = $warehouse   AND s_shipping.shipping_type IN(8,9,7,10)  AND `s_shipping_products`.`created_at` < '$start'")-> queryAll();
          $not_in = '';
          if(!empty($opening_)){
             foreach($opening_ as $product => $product_simple){
                $not_in.="'".$product_simple['mac_address']."',";
             }
          }
          if($not_in){
            $not_in = substr($not_in,0,-1);
            $not_in = " s_product.mac_address NOT IN($not_in) AND";
          }
         $opening = Yii::$app
                ->db
                ->createCommand("SELECT s_shipping.*,s_product.mac_address FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE $not_in  s_product.nomenclature_product_id = $nomeclature_id AND s_shipping.supplier_warehouse_id = $warehouse   AND s_shipping.shipping_type IN(2,6,7)  AND `s_shipping_products`.`created_at` < '$start'")->queryAll();
            
          
       return $opening;
    }
     public function findByClosing($data){
         $end = date('Y-m-d', strtotime($data['to_created_at']));
        $start = date('Y-m-d', strtotime($data['from_created_at']));
        $warehouse_id = intval($data['supplier_warehouse_id']);
        $nomeclature_id = intval($data['nomeclature_id']);
        $warehouse = intval($data['wid']);

         if (!$warehouse_id) {
            $wSql = "";
         } else {
            $wSql = "AND s_shipping.supplier_warehouse_id = $warehouse_id";
         }
         $closing_ = Yii::$app
                ->db
                ->createCommand("SELECT s_product.mac_address FROM s_shipping_products            
                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id
                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                  WHERE  s_product.nomenclature_product_id = $nomeclature_id AND s_shipping.provider_warehouse_id = $warehouse   AND s_shipping.shipping_type IN(8,9,7,10)  AND `s_shipping_products`.`created_at` < '$end'")-> queryAll();
          $not_in = '';
          if(!empty($closing_)){
             foreach($closing_ as $product => $product_simple){
                $not_in.="'".$product_simple['mac_address']."',";
             }
          }
          if($not_in){
            $not_in = substr($not_in,0,-1);
            $not_in = " s_product.mac_address NOT IN($not_in) AND";
          }

         $closing = Yii::$app
                ->db
                ->createCommand("SELECT s_shipping.*,s_product.mac_address FROM s_shipping_products            
                                                     LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id
                                                     LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                                                  WHERE $not_in  s_product.nomenclature_product_id = $nomeclature_id AND s_shipping.supplier_warehouse_id = $warehouse   AND s_shipping.shipping_type IN(2,6,7)  AND `s_shipping_products`.`created_at` < '$end'")->queryAll();     
   
       return $closing;
    }
    public function findBySellOut($data){
        $end = date('Y-m-d', strtotime($data['to_created_at']));
        $start = date('Y-m-d', strtotime($data['from_created_at']));
        $warehouse_id = intval($data['supplier_warehouse_id']);
        $nomeclature_id = intval($data['nomeclature_id']);
        $warehouse = intval($data['wid']);
       
         if (!$warehouse_id) {
            $wSql = "";
         } else {
            $wSql = "AND s_shipping.supplier_warehouse_id = $warehouse_id";
         }
         $sell_out = Yii::$app
            ->db
            ->createCommand("SELECT s_shipping.*,s_product.mac_address,s_shipping_products.count as Pcount FROM s_shipping_products            
                         LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id 
                         LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                      WHERE  s_product.nomenclature_product_id = $nomeclature_id AND s_shipping.provider_warehouse_id = $warehouse $wSql AND s_shipping.shipping_type IN(8,9,7,10) AND  `s_shipping_products`.`created_at` >= '$start' AND `s_shipping_products`.`created_at` <= '$end'")->queryAll();
         return $sell_out;
       
    }
     public function findBySellin($data){
        $end = date('Y-m-d', strtotime($data['to_created_at']));
        $start = date('Y-m-d', strtotime($data['from_created_at']));
        $warehouse_id = intval($data['supplier_warehouse_id']);
        $nomeclature_id = intval($data['nomeclature_id']);
        $warehouse = intval($data['wid']);
       
        $sell_out = Yii::$app->db
         ->createCommand("SELECT s_shipping.*,s_product.mac_address,s_shipping_products.count as Pcount FROM s_shipping_products            
                         LEFT JOIN s_shipping ON s_shipping_products.shipping_id = s_shipping.id 
                         LEFT JOIN s_product ON s_product.id = s_shipping_products.product_id
                      WHERE  s_product.nomenclature_product_id = $nomeclature_id AND s_shipping.supplier_warehouse_id = $warehouse AND  s_shipping.shipping_type IN(2,5,6,7) AND  `s_shipping_products`.`created_at` >= '$start' AND `s_shipping_products`.`created_at` <= '$end'")->queryAll();
         
         return $sell_out;
       
    }
    public function getBarcodes() {
        $bs = Barcode::find()->where(['product_id' => $this->id])->all();
        $res = '';
        foreach ($bs as $b) {
            $res .= '<span>' . $b->code . '</span><br>';
        }

        return $res;
    }
}