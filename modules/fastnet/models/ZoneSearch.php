<?php

namespace app\modules\fastnet\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\fastnet\models\Zone;

/**
 * ZoneSearch represents the model behind the search form of `app\modules\fastnet\models\Zone`.
 */
class ZoneSearch extends Zone
{

    public $community_id;

    public $street_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'country_id', 'region_id', 'city_id', 'community_id', 'street_id'], 'safe'],
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
        $query = Zone::find()
            ->joinWith('zoneCities')
            ->joinWith('zoneRegions')
            ->joinWith('zoneCountries')
            ->joinWith('zoneCommunities')
            ->joinWith('zoneStreets');

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
            'id' => $this->id
        ]);

        if ($this->city_id) {
            $query->andFilterWhere(['LIKE', 'cities.name', $this->city_id]);
        }

        if ($this->region_id) {
            $query->andFilterWhere(['LIKE', 'regions.name', $this->region_id]);
        }

        if ($this->country_id) {
            $query->andFilterWhere(['LIKE', 'countries.name', $this->country_id]);
        }

        if ($this->community_id) {
            $query->andFilterWhere(['LIKE', 'f_community.name', $this->community_id]);
        }

        if ($this->street_id) {
            $query->andFilterWhere(['LIKE', 'f_streets.name', $this->street_id]);
        }

        return $dataProvider;
    }
}
