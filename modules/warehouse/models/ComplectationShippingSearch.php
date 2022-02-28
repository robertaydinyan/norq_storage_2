<?php

namespace app\modules\warehouse\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\warehouse\models\ComplectationShipping;

/**
 * ComplectationShippingSearch represents the model behind the search form of `app\modules\warehouse\models\ComplectationShipping`.
 */
class ComplectationShippingSearch extends ComplectationShipping
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'n_product_count', 'complectation_id', 'product_id'], 'integer'],
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
    public function search($params, $compectation_id = null)
    {

        if ($compectation_id === null) {
            $query = ComplectationShipping::find();
        } else {
            $query = ComplectationShipping::find()->where(['complectation_id' => $compectation_id]);
        }
        //$query = ComplectationShipping::find();

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
            'n_product_count' => $this->n_product_count,
            'complectation_id' => $this->complectation_id,
            'product_id' => $this->product_id,
        ]);

        return $dataProvider;
    }
}
