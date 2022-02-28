<?php

namespace app\modules\crm\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\crm\models\CashRegisterReceipt;

/**
 * CashRegisterReceiptSearch represents the model behind the search form of `app\modules\crm\models\CashRegisterReceipt`.
 */
class CashRegisterReceiptSearch extends CashRegisterReceipt
{

    public $price;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'payment_log_id', 'cashier_id', 'created_by'], 'integer'],
            [['accepted_at', 'create_at', 'price'], 'safe'],
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
        $query = CashRegisterReceipt::find()
            ->joinWith(['paymentLog', 'paymentLog.dealFast', 'cashier'])
            ->where(['cashier_id' => \Yii::$app->user->identity->cashierOperator->cashier_id]);

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

        $dataProvider->sort->attributes['payment_log_id'] = [
            'asc'  => ['f_deal.deal_number' => SORT_ASC],
            'desc' => ['f_deal.deal_number' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['price'] = [
            'asc'  => ['deal_payment_log.price' => SORT_ASC],
            'desc' => ['deal_payment_log.price' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cashier_id' => $this->cashier_id,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'f_deal.deal_number', $this->payment_log_id]);
        $query->andFilterWhere(['like', 'deal_payment_log.price', $this->price]);

        if ($this->accepted_at && strpos($this->accepted_at, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->accepted_at);
            $query->andFilterWhere(['between', 'DATE(accepted_at)', date('Y-m-d', strtotime($start_date)), date('Y-m-d', strtotime($end_date))]);
        }

        if ($this->create_at && strpos($this->create_at, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->create_at);
            $query->andFilterWhere(['between', 'DATE(create_at)', date('Y-m-d', strtotime($start_date)), date('Y-m-d', strtotime($end_date))]);
        }

        return $dataProvider;
    }
}
