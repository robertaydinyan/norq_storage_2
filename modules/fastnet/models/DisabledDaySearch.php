<?php

namespace app\modules\fastnet\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\fastnet\models\DisabledDay;

/**
 * DisabledDaySearch represents the model behind the search form of `app\modules\fastnet\models\DisabledDay`.
 */
class DisabledDaySearch extends DisabledDay
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'disabled_day', 'disabled_price_day'], 'integer'],
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
        $query = DisabledDay::find();

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
            'disabled_day' => $this->disabled_day,
            'disabled_price_day' => $this->disabled_price_day,
        ]);

        return $dataProvider;
    }
}
