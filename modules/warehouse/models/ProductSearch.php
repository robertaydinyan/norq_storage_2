<?php

namespace app\modules\warehouse\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\warehouse\models\Product;

/**
 * ProductSearch represents the model behind the search form of `app\modules\warehouse\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'warehouse_id', 'nomenclature_product_id'], 'integer'],
            [['price', 'retail_price'], 'number'],
            [['supplier_name', 'mac_address', 'comment', 'used', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function childTree(array $tableTreeGroups) {

        $result = [];


        foreach ($tableTreeGroups as $treeGroup) {
            if (!isset($treeGroup['children'])){
                $result[] = $treeGroup['id'];
            } else {
                $result = array_merge($result, $this->childTree($treeGroup['children']));
            }
        }
        return $result;
    }


    public function buildTree(array $elements, $parentId = null) {

        $branch = array();
        foreach ($elements as $element) {

            if ($element['group_id'] == $parentId) {

                $children = $this->buildTree($elements, $element['id']);

                if ($children) {

                    $element['children'] =  $children;

                }

                $branch[] = $element;

            }

        }
        return $branch;

    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {

        $whProductsCount = Yii::$app->db->createCommand("
                SELECT COUNT(`s_product`.id) as total_count 
                FROM `s_product` 
                LEFT JOIN `s_nomenclature_product` ON `s_product`.`nomenclature_product_id` = `s_nomenclature_product`.`id` 
                LEFT JOIN `s_qty_type` ON `s_nomenclature_product`.`qty_type_id` = `s_qty_type`.`id` 
                LEFT JOIN `s_warehouse` ON `s_product`.`warehouse_id` = `s_warehouse`.`id` 
                WHERE `status`=1 AND s_product.count>0 
                GROUP BY `s_product`.`warehouse_id`,`s_product`.`nomenclature_product_id`  "
        )->queryAll();
        if (!isset ($_GET['page']) ) {  
            $page = 1;  
        } else {  
            $page = intval($_GET['page']);  
        }  
        $results_per_page = 10;  
        $page_first_result = ($page-1) * $results_per_page;  
        $number_of_page = ceil (count($whProductsCount) / $results_per_page);  
        $whProducts = Yii::$app->db->createCommand(
            "SELECT s_warehouse.name as wname,
                        s_nomenclature_product.img,
                        s_nomenclature_product.id as nid,
                        s_qty_type.type,
                        s_nomenclature_product.individual,
                        s_nomenclature_product.name as nomeclature_name,
                        s_warehouse.id,
                        s_warehouse.type,
                        nomenclature_product_id, 
                        sum(count) AS `count_n_product` 
            FROM `s_product` LEFT JOIN `s_nomenclature_product` ON `s_product`.`nomenclature_product_id` = `s_nomenclature_product`.`id` 
            LEFT JOIN `s_qty_type` ON `s_nomenclature_product`.`qty_type_id` = `s_qty_type`.`id` 
            LEFT JOIN `s_warehouse` ON `s_product`.`warehouse_id` = `s_warehouse`.`id` 
            WHERE `status`=1 AND s_product.count>0 GROUP BY  `s_product`.`warehouse_id`,`s_product`.`nomenclature_product_id` 
            ORDER BY `count_n_product` 
            LIMIT " . $page_first_result . ',' . $results_per_page)->queryAll();
        
        return ['result' => $whProducts, 'params' => $params,'total'=>$number_of_page];
    }

    /**
     * @param $article
     * @param STRING $rows
     * @return ActiveDataProvider
     */
    public function search_($article, $rows = '') {
        $query = Product::find()
            ->where(['>','count',0])
            ->andWhere(['>','warehouse_id',0])
            ->groupBy(['warehouse_id','nomenclature_product_id'])
            ->indexBy('id'); // where `id` is your primary key

        if ($article) {
            $query->andWhere(['like', 'article', $article]);
        }
        if (isset($rows) && $rows->column_name) {
            if (!$this->hasAttribute($rows->column_name)) {

                if ($rows->column_name == "NomenclatureName") {
                    $query->leftJoin('s_nomenclature_product', '`s_nomenclature_product`.`id`= `s_product`.`nomenclature_product_id`');
                    $sort = 's_nomenclature_product.name';
                } elseif ($rows->column_name == "WarehouseName") {
                    $query->leftJoin('s_warehouse', '`s_warehouse`.`id`= `s_product`.`warehouse_id`');
                    $sort = 's_warehouse.name';
                } elseif ($rows->column_name == "qty_type") {
                    $query->leftJoin('s_qty_type', '`s_qty_type`.`id`= `s_product`.`warehouse_id`');
                    $sort = 's_qty_type.type';
                } elseif ($rows->column_name == "Individual") {
                    $query->leftJoin('s_nomenclature_product', '`s_nomenclature_product`.`id`= `s_product`.`nomenclature_product_id`');
                    $sort = 's_nomenclature_product.individual';
                } elseif ($rows->column_name == "Quantity") {
                    $sort = 's_product.count';
                } elseif ($rows->column_name == "article") {
                    $sort = 's_product.article';
                } elseif ($rows->column_name == "barcodes") {
                    $query->leftJoin('barcode', '`barcode`.`product_id`= `s_product`.`id`');
                    $sort = 'barcode.code';
                }
            }
            else {

                $sort = $rows->column_name;
            }
        }

        if ($sort) {
            $query->orderBy([$sort => ($rows->direction == "DESC" ? SORT_DESC : SORT_ASC)]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        return $dataProvider;
    }

}


