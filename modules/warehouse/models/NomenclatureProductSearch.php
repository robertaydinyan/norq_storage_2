<?php

namespace app\modules\warehouse\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\warehouse\models\NomenclatureProduct;

/**
 * NomenclatureProductSearch represents the model behind the search form of `app\modules\warehouse\models\NomenclatureProduct`.
 */
class NomenclatureProductSearch extends NomenclatureProduct
{
    public  $groupName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'group_id'], 'integer'],
            [['vendor_code_hy', 'vendor_code_ru', 'vendor_code_en', 'name_hy', 'name_ru', 'name_en', 'groupName', 'production_date', 'individual', 'qty_type_id'], 'safe'],
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
        $query = NomenclatureProduct::find()
            ->joinWith('groupProduct');


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

        $dataProvider->sort->attributes['groupName'] = [
            'asc'  => ['s_group_product.name' => SORT_ASC],
            'desc' => ['s_group_product.name' => SORT_DESC],
        ];
        if(isset($_GET['id'])){
            $query->andFilterWhere([
                's_nomenclature_product.group_id' => intval($_GET['id']),
            ]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'production_date' => $this->production_date,
            'group_id' => $this->group_id,
        ]);

        $query->andFilterWhere(['like', 'vendor_code', $this->vendor_code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 's_group_product.name', $this->groupName])
            ->andFilterWhere(['like', 'individual', $this->individual])
            ->andFilterWhere(['like', 'qty_type_id', $this->qty_type_id]);

        return $dataProvider;
    }
}
