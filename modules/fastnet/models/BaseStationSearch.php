<?php

namespace app\modules\fastnet\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\fastnet\models\BaseStation;

/**
 * BaseStationSearch represents the model behind the search form of `app\modules\fastnet\models\BaseStation`.
 */
class BaseStationSearch extends BaseStation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'ip','ip_end', 'zona_id'], 'safe'],
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
        $query = BaseStation::find();

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'ip_end', $this->ip])
            ->andFilterWhere(['like', 'zona_id', $this->zona_id]);
        return $dataProvider;
    }
}
