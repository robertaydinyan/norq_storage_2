<?php

namespace app\modules\warehouse\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\warehouse\models\Complectation;

/**
 * ComplectationSearch represents the model behind the search form of `app\modules\warehouse\models\Complectation`.
 */
class ComplectationSearch extends Complectation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'new_product_count', 'nomenclature_product_id', 'provider_warehouse_id', 'supplier_warehouse_id'], 'integer'],
            [['new_product_price', 'service_fee'], 'number'],
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
    public function search($params)
    {
        $query = Complectation::find();

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
            'new_product_price' => $this->new_product_price,
            'service_fee' => $this->service_fee,
            'new_product_count' => $this->new_product_count,
            'created_at' => $this->created_at,
            'nomenclature_product_id' => $this->nomenclature_product_id,
            'provider_warehouse_id' => $this->provider_warehouse_id,
            'supplier_warehouse_id' => $this->supplier_warehouse_id,
        ]);

        return $dataProvider;
    }
}
