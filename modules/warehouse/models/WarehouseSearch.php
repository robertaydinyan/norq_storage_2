<?php

namespace app\modules\warehouse\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\warehouse\models\Warehouse;

/**
 * WarehouseSearch represents the model behind the search form of `app\modules\warehouse\models\Warehouse`.
 */
class WarehouseSearch extends Warehouse
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'responsible_id', 'crm_company_id', 'crm_contact_id'], 'integer'],
            [['type', 'name', 'responsible_id', 'created_at', 'updated_at'], 'safe'],
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
    /**
     * @param $article
     * @param STRING $rows
     * @return ActiveDataProvider
     */
    public function search($article, $rows = '')
    {

        $query = Warehouse::find();

        // add conditions that should always apply here
        // if ($article) {
        //     $query->andWhere(['like', 'article', $article]);
        // }

        if (isset($rows) && $rows->column_name) {
            if (!$this->hasAttribute($rows->column_name)) {
                if ($rows->column_name == "name") {
                    $sort = 's_warehouse.name';
                } elseif ($rows->column_name == "responsible_id") {
                    $query->leftJoin('user', '`user`.`id`= `s_product`.`responsible_id`');
                    $sort = 'user.name';
                }
            } else {
                 $sort = $rows->column_name;

            }

        }
        if ($sort) {
            $query->orderBy([$sort => ($rows->direction == "DESC" ? SORT_DESC : SORT_ASC)]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // $this->load($article);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if(isset($_GET['type'])){
            $query->andFilterWhere([
                's_warehouse.type' => intval($_GET['type']),
            ]);
        }
        if(isset($_GET['group_id'])){
            $query->andFilterWhere([
                's_warehouse.group_id' => intval($_GET['group_id']),
            ]);
        }
        if(isset($_GET['region']) && intval($_GET['region'])){
            $query->joinWith(['contactAdress']);
            $query->andFilterWhere([
                'contact_adress.region_id' => intval($_GET['region']),
            ]);
        }
        if(isset($_GET['community']) && intval($_GET['community'])){
            $query->joinWith(['contactAdress']);
            $query->andFilterWhere([
                'contact_adress.community_id' => intval($_GET['community']),
            ]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'responsible_id' => $this->responsible_id,
            'crm_company_id' => $this->crm_company_id,
            'crm_contact_id' => $this->crm_contact_id,
        ]);
        $query->andFilterWhere(['like', 'type', $this->type])
//            ->andFilterWhere(['like', 'country', $this->country])
//            ->andFilterWhere(['like', 'region', $this->region])
//            ->andFilterWhere(['like', 'city', $this->city])
//            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'responsible_id', $this->responsible_id])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}