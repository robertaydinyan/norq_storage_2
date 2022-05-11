<?php

namespace app\modules\warehouse\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\warehouse\models\ShippingRequest;
use yii\web\Request;

/**
 * ShippingRequestSearch represents the model behind the search form of `app\modules\warehouse\models\ShippingRequest`.
 */
class ShippingRequestSearch extends ShippingRequest
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'count', 'nomenclature_product_id'], 'integer'],
            [['created_at'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */

    /**
     * @param $article
     * @param STRING $rows
     * @return ActiveDataProvider
     */
    public function search($article , $rows = false)
    {
       /* $query = $rows->id != null ? ShippingRequest::find()->where(['id' => $rows->id]) : ShippingRequest::find();

        $query->joinWith(['nProduct']);*/

       $query = ShippingRequest::find();
        //varDumper($shippingId,  $query->asArray()->all()); die;

        // add conditions that should always apply here

        if ($article) {
            $query->andWhere(['like', 'article', $article]);
        }
        if (isset($rows) && $rows->column_name) {

            if (!$this->hasAttribute($rows->column_name)) {

                if ($rows->column_name == "shippingType") {
                    $query->leftJoin('s_shipping_type', '`s_shipping_type`.`id`= `s_shipping`.`shipping_type`');
                    $sort = 's_shipping_type.name';
                } elseif ($rows->column_name == "providerWarehouse") {
                    $query->leftJoin('s_warehouse', '`s_warehouse`.`id`= `s_shipping`.`provider_warehouse_id`');
                    $sort = 's_warehouse.name';
                } elseif ($rows->column_name == "supplierWarehouse") {
                    $query->leftJoin('s_warehouse', '`s_warehouse`.`id`= `s_shipping`.`provider_warehouse_id`');
                    $sort = 's_warehouse.name';
                } elseif ($rows->column_name == "supplier") {
                    $query->leftJoin('user', '`user`.`id`= `s_shipping`.`user_id`');
                    $sort = 'user.name';
                } elseif ($rows->column_name == "created") {
                    $sort = 's_shipping.created_at';
                }elseif ($rows->column_name == "status") {
                    var_dump('a');
                    $query->leftJoin('s_status_list', '`s_status_list`.`id`= `s_shipping`.`status`');
                    $sort = 's_status_list.name';
                } elseif ($rows->column_name == "document_type") {
                    $query->leftJoin('s_status_list', '`s_status_list`.`id`= `s_shipping`.`status`');
                    $sort = 's_status_list.name';
                } elseif ($rows->column_name == "totalAmount") {
                    $query->leftJoin('s_shipping_products', '`s_shipping_products`.`shipping_id`= `s_shipping`.`id`');

                    $query->select('SUM(s_shipping_products.price * s_shipping_products.count) as totalAmount, s_shipping.*');
                    $query->groupBy('s_shipping.id');
                    $sort = 'totalAmount';
                }
            } else {
                $sort = $rows->column_name;
            }
        }
        if ($sort) {
            $query->orderBy([$sort => ($rows->direction == "DESC" ? SORT_DESC : SORT_ASC)]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($article);




        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if(isset($_GET['type'])){
            $query->andFilterWhere([
                's_shipping.shipping_type' => intval($_GET['type']),
            ]);
        }
        if(isset($_GET['ShippingRequest']['supplier_id'])){
            $query->andFilterWhere([
                's_shipping.supplier_id' => intval( $_GET['ShippingRequest']['supplier_id']),
            ]);
        }

        if(isset($_GET['created_at'])){
            $query->andFilterWhere([
                's_shipping.created_at' => $_GET['created_at'],
            ]);
        }
        if(\Yii::$app->user->can('technician') && !\Yii::$app->user->can('admin')) {
            $warehouseId = Warehouse::find()->where(['user_id'=>Yii::$app->user->getId()])->one()->id;
            $query->AndWhere(['or',
                ['s_shipping.supplier_warehouse_id' => $warehouseId],
                ['s_shipping.provider_warehouse_id' => $warehouseId]
            ]);


        } else {

            if(isset($_GET['supplier_warehouse_id'])){
                $query->andFilterWhere([
                    's_shipping.supplier_warehouse_id' => $_GET['supplier_warehouse_id'],
                ]);
            }
            if(isset($_GET['provider_warehouse_id'])){
                $query->andFilterWhere([
                    's_shipping.provider_warehouse_id' => $_GET['provider_warehouse_id'],
                ]);
            }
        }
        if(isset($_GET['user_id'])){
            $query->andFilterWhere([
                's_shipping.user_id' => $_GET['user_id'],
            ]);
        }
        $query->andFilterWhere([
            's_shipping.status' => 3,
        ]);
        if(isset($_GET['from_created_at'])){
            $query->andFilterWhere([
                '>','s_shipping.created_at', $_GET['from_created_at'],
            ]);
        }

        if(isset($_GET['to_created_at'])){

            $query->andFilterWhere([
                '<','s_shipping.created_at', $_GET['to_created_at'],
            ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            's_shipping.id' => $this->id,
            's_shipping.count' => $this->count,
            's_shipping.nomenclature_product_id' => $this->nomenclature_product_id,
        ]);

        return $dataProvider;
    }
}