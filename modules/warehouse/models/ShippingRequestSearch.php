<?php

namespace app\modules\warehouse\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\warehouse\models\ShippingRequest;

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
    public function search($params , $shippingId = null,$is_doc = false)
    {
        $query = $shippingId != null ? ShippingRequest::find()->where(['id' => $shippingId]) : ShippingRequest::find();

        $query->joinWith(['nProduct']);
        //varDumper($shippingId,  $query->asArray()->all()); die;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);


        

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if(isset($_GET['type'])){
            $query->andFilterWhere([
                'shipping_type' => intval($_GET['type']),
            ]);
        }
        if(isset($_GET['ShippingRequest']['supplier_id'])){
            $query->andFilterWhere([
                'supplier_id' => intval( $_GET['ShippingRequest']['supplier_id']),
            ]);
        }
       
        if(isset($_GET['created_at'])){
            $query->andFilterWhere([
                'created_at' => $_GET['created_at'],
            ]);
        }
        if(\Yii::$app->user->can('technician') && !\Yii::$app->user->can('admin')) {
            $warehouseId = Warehouse::find()->where(['user_id'=>Yii::$app->user->getId()])->one()->id;
                $query->AndWhere(['or',
                    ['supplier_warehouse_id' => $warehouseId],
                    ['provider_warehouse_id' => $warehouseId]
                ]);
 
        
        } else {

            if(isset($_GET['supplier_warehouse_id'])){
                $query->andFilterWhere([
                    'supplier_warehouse_id' => $_GET['supplier_warehouse_id'],
                ]);
            }
            if(isset($_GET['provider_warehouse_id'])){
                $query->andFilterWhere([
                    'provider_warehouse_id' => $_GET['provider_warehouse_id'],
                ]);
            }
        }
        if(isset($_GET['user_id'])){
            $query->andFilterWhere([
                'user_id' => $_GET['user_id'],
            ]);
        }
        if($is_doc){
            $query->andFilterWhere([
                'status' => 3,
            ]);
        } else {
            $query->andFilterWhere([
                '!=','status',3
            ]);
        }
        if(isset($_GET['from_created_at'])){
            $query->andFilterWhere([
                '>','created_at', $_GET['from_created_at'],
            ]);
        }

        if(isset($_GET['to_created_at'])){

            $query->andFilterWhere([
                '<','created_at', $_GET['to_created_at'],
            ]);
        }
     
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'count' => $this->count,
            'nomenclature_product_id' => $this->nomenclature_product_id,
        ]);

        return $dataProvider;
    }
}