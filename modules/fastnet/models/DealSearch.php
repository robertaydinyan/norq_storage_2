<?php

namespace app\modules\fastnet\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\fastnet\models\Deal;

/**
 * DealSearch represents the model behind the search form of `app\modules\fastnet\models\Deal`.
 */
class DealSearch extends Deal
{
    public $base_station_ip;

    public $address;

    public $ip_count;

//    public $crm_contact_id;

    public $monthly_pay;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'contact_id', 'is_provider', 'user_type', 'connect_id'], 'integer'],
            [['deal_number', 'connection_day', 'base_station_id', 'address', 'ip_count', 'monthly_pay', 'crm_contact_id', 'crm_company_id', 'start_day', 'is_daily', 'month'], 'safe'],
            [['amount', 'penalty', 'electricity', 'discount'], 'number'],
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
        $query = Deal::find()
            ->where(['not in', 'f_deal.status', [self::SUSPENDED, self::CLOSED]])
            ->joinWith(['tariff', 'station', 'contactAddress.country', 'contactAddress.region', 'contactAddress.community', 'contactAddress.city', 'contactAddress.fastStreet', 'dealIps', 'crmContact', 'crmCompany']);

        # Filter by ip count
        $subQuery = DealIp::find()->select('COUNT(deal_number) as deal_ip_count');
        $query->leftJoin(['dealIps' => $subQuery], 'f_deal_ip.deal_number = f_deal.deal_number');

        # Filter by price

//        $subQueryPrice = Tariff::find()->select('(inet_price + tv_packet.price) as prices')->joinWith('tv');
//        $query->leftJoin(['tariff' => $subQueryPrice], 'f_tariff.id = f_deal.connect_id');

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

        $dataProvider->sort->attributes['ip_count'] = [
            'asc'  => ['dealIps.deal_ip_count' => SORT_ASC],
            'desc' => ['dealIps.deal_ip_count' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['amount'] = [
            'asc'  => ['tariff.prices' => SORT_ASC],
            'desc' => ['tariff.prices' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['connect_id'] = [
            'asc'  => ['f_tariff.id' => SORT_ASC],
            'desc' => ['f_tariff.id' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['base_station_id'] = [
            'asc'  => ['f_base_station.id' => SORT_ASC],
            'desc' => ['f_base_station.id' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['crm_contact_id'] = [
            'asc'  => ['crm_contact.name' => SORT_ASC],
            'desc' => ['crm_contact.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['crm_company_id'] = [
            'asc'  => ['crm_company.id' => SORT_ASC],
            'desc' => ['crm_company.id' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'contact_id' => $this->contact_id,
            'user_type' => $this->user_type,
            'penalty' => $this->penalty,
            'electricity' => $this->electricity,
            'discount' => $this->discount,
            'is_daily' => $this->is_daily,
            'month' => $this->month,
        ]);

        $query->andFilterWhere(['LIKE', 'f_deal.deal_number', $this->deal_number])->orderBy(['deal_number' => SORT_ASC]);
        $query->andFilterWhere(['f_tariff.id' => $this->connect_id]);
        $query->andFilterWhere(['f_base_station.id' => $this->base_station_id]);

        if ($this->address) {
            $query->andFilterWhere(['LIKE', 'countries.name', $this->address])
                ->orFilterWhere(['LIKE', 'cities.name', $this->address])
                ->orFilterWhere(['LIKE', 'regions.name', $this->address])
                ->orFilterWhere(['LIKE', 'f_community.name', $this->address])
                ->orFilterWhere(['LIKE', 'f_streets.name', $this->address]);
        }

        # Connection day between date range
        if ($this->connection_day && strpos($this->connection_day, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->connection_day);
            $query->andFilterWhere(['between', 'DATE(connection_day)', date('Y-m-d', strtotime($start_date)), date('Y-m-d', strtotime($end_date))]);
        }

        if ($this->start_day && strpos($this->start_day, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->start_day);
            $query->andFilterWhere(['between', 'DATE(start_day)', date('Y-m-d', strtotime($start_date)), date('Y-m-d', strtotime($end_date))]);
        }

        # Filter by ip count
        if ($this->ip_count) {
            $query->andFilterWhere(['dealIps.deal_ip_count' => $this->ip_count]);
        }

        if ($this->amount) {
            $query->andFilterWhere(['tariff.prices' => $this->amount]);
        }

        if ($this->crm_contact_id) {
            $query->andFilterWhere(['crm_contact.id' => $this->crm_contact_id]);
        }

        if ($this->crm_company_id) {
            $query->andFilterWhere(['crm_company.id' => $this->crm_company_id]);
        }

        if ($this->is_provider) {
            $query->andFilterWhere(['f_deal.is_provider' => $this->is_provider]);
        }

        return $dataProvider;
    }
}
