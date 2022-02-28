<?php

namespace app\modules\crm\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\crm\models\Cashier;

/**
 * CashierSearch represents the model behind the search form of `app\modules\crm\models\Cashier`.
 */
class CashierSearch extends Cashier
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_active', 'virtual'], 'integer'],
            [['name', 'operator_id'], 'safe'],
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
        $query = Cashier::find()->joinWith('operator');

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
            'is_active' => $this->is_active,
            'virtual' => $this->virtual,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        if ($this->operator_id) {
            $query->andFilterWhere(['like', 'user.id', $this->operator_id]);
        }

        return $dataProvider;
    }
}
