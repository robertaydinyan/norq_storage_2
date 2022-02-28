<?php

namespace app\modules\fastnet\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\fastnet\models\Tariff;

/**
 * TariffSearch represents the model behind the search form of `app\modules\fastnet\models\Tariff`.
 */
class TariffSearch extends Tariff
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'availability', 'inet_speed', 'tv_id', 'ip_count', 'type'], 'integer'],
            [['name', 'create_at', 'update_at'], 'safe'],
            [['inet_price'], 'number'],
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
        $query = Tariff::find();

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
            'availability' => $this->availability,
            'inet_speed' => $this->inet_speed,
            'inet_price' => $this->inet_price,
            'tv_id' => $this->tv_id,
            'ip_count' => $this->ip_count,
            'type' => $this->type,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
