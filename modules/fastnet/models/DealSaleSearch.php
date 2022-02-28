<?php

namespace app\modules\fastnet\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\fastnet\models\DealSale;

/**
 * DealSaleSearch represents the model behind the search form of `app\modules\fastnet\models\DealSale`.
 */
class DealSaleSearch extends DealSale
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'deal_id'], 'integer'],
            [['month'], 'safe'],
            [['price'], 'number'],
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
        $query = DealSale::find();

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
            'deal_id' => $this->deal_id,
            'month' => $this->month,
            'price' => $this->price,
        ]);

        return $dataProvider;
    }
}
