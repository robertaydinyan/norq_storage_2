<?php

namespace app\modules\warehouse\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\warehouse\models\Shipping;

/**
 * ShippingSearch represents the model behind the search form of `app\modules\warehouse\models\Shipping`.
 */
class ShippingSearch extends Shipping
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'provider_warehouse_id', 'supplier_warehouse_id'], 'integer'],
            [['created_at', 'shipping_type'], 'safe'],
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
    public function search($params, $warehouseId = null)
    {
        if(\Yii::$app->user->can('technician')) {
            $warehouseId = Warehouse::find()->where(['user_id'=>Yii::$app->user->getId()])->id;
        }
        if (\Yii::$app->user->identity->username === 'ashotfast') {
            $query = Shipping::find()
            ->joinWith(['toWarehouse', 'fromWarehouse']);

        } else {
            $query = Shipping::find()
                ->joinWith(['toWarehouse', 'fromWarehouse'])
                ->andWhere(['s_warehouse.id' => $warehouseId]);

        }

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'shipping_type' => $this->shipping_type,
            'provider_warehouse_id' => $this->provider_warehouse_id,
            'supplier_warehouse_id' => $this->supplier_warehouse_id,
        ]);



        return $dataProvider;
    }
}
