<?php

namespace app\modules\billing\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\billing\models\TvPacketChannel;

/**
 * TvPacketChannelSearch represents the model behind the search form of `app\modules\billing\models\TvPacketChannel`.
 */
class TvPacketChannelSearch extends TvPacketChannel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['packet_id', 'channel_id', 'price'], 'integer'],
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
        $query = TvPacketChannel::find();

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
            'packet_id' => $this->packet_id,
            'channel_id' => $this->channel_id,
            'price' => $this->price,
        ]);

        return $dataProvider;
    }
}
