<?php

namespace app\modules\billing\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DealPaymentLogSearch represents the model behind the search form of `app\modules\billing\models\DealPaymentLog`.
 */
class DealPaymentLogSearch extends DealPaymentLog
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'deal_id', 'operator_id', 'status', 'payment_type', 'payer', 'hdm'], 'integer'],
            [['price'], 'number'],
            [['create_at', 'update_at', 'blacklisted', 'is_daily'], 'safe'],
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
     * @param bool $onlyAuthenticatedUser
     * @return ActiveDataProvider
     */
    public function search($params, $onlyAuthenticatedUser = false)
    {
        $query = DealPaymentLog::find();

//        if (!\Yii::$app->user->can('seeAllPayments')) {
//            $query->where(['deal_payment_log.payer' => \Yii::$app->user->identity->cashierOperator->cashier_id])
//                ->orWhere(['is', 'deal_payment_log.payer', new \yii\db\Expression('null')]);
//        }

        $query->joinWith(['deal', 'cashier', 'cashier.operator', 'cashierPayer.operator']);

//        if ($onlyAuthenticatedUser) {
//            $userId = \Yii::$app->user->id;
//
//            $query->joinWith('cashier.operator', function ($userPayments) use ($userId) {
//                $userPayments->andWhere(['f_cashier_operator.operator_id' => $userId]);
//            });
//        } else {
//            $query->joinWith('cashier.operator');
//        }

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

        $dataProvider->sort->attributes['deal_id'] = [
            'asc'  => ['f_deal.deal_number' => SORT_ASC],
            'desc' => ['f_deal.deal_number' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['create_at'] = [
            'asc'  => ['deal_payment_log.create_at' => SORT_ASC],
            'desc' => ['deal_payment_log.create_at' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['blacklisted'] = [
            'asc'  => ['f_deal.blacklist' => SORT_ASC],
            'desc' => ['f_deal.blacklist' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['is_daily'] = [
            'asc'  => ['f_deal.is_daily' => SORT_ASC],
            'desc' => ['f_deal.is_daily' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['update_at'] = [
            'asc'  => ['deal_payment_log.update_at' => SORT_ASC],
            'desc' => ['deal_payment_log.update_at' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['payment_type'] = [
            'asc'  => ['cashier.payment_type' => SORT_ASC],
            'desc' => ['cashier.payment_type' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'status' => $this->status,
            'hdm' => $this->hdm,
        ])->andFilterWhere(['like', 'f_deal.deal_number', $this->deal_id]);

        # Created at between date range
        if ($this->create_at && strpos($this->create_at, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->create_at);
            $query->andFilterWhere(['between', 'DATE(deal_payment_log.create_at)', date('Y-m-d', strtotime($start_date)), date('Y-m-d', strtotime($end_date))]);
        }

        # Updated at between date range
        if ($this->update_at && strpos($this->update_at, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->update_at);
            $query->andFilterWhere(['between', 'DATE(deal_payment_log.update_at)', date('Y-m-d', strtotime($start_date)), date('Y-m-d', strtotime($end_date))]);
        }

        # Search operator assigned to model cashier
        if ($this->operator_id && !$onlyAuthenticatedUser) {
            $query->andFilterWhere(['f_cashier_operator.operator_id' => $this->operator_id]);
        } elseif ($onlyAuthenticatedUser) {  # Show only authenticated user payment log if the cashier is virtual.
            $userId = \Yii::$app->user->id;
            $query->andFilterWhere(['f_cashier_operator.operator_id' => $userId]);
        }

        if ($this->payer) {
            $query->andFilterWhere(['f_cashier_operator.operator_id' => $this->payer]);
        }

        if ($this->payment_type) {
            $query->andFilterWhere(['f_cashier.id' => $this->payment_type]);
        }

        if ($this->blacklisted) {
            $query->andFilterWhere(['f_deal.blacklist' => $this->blacklisted]);
        }

        if ($this->is_daily) {
            $query->andFilterWhere(['f_deal.is_daily' => $this->is_daily]);
        }

        return $dataProvider;
    }
}
