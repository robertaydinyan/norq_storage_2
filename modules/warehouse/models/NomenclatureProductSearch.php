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
            [['vendor_code', 'name', 'groupName', 'production_date', 'individual', 'qty_type_id'], 'safe'],
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
     * @param TableRowsCount $rows
     * @return ActiveDataProvider
     */
    public function search($params, $rows = false)
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
        if (isset($rows) && $rows->column_name) {
            if (!$this->hasAttribute($rows->column_name)) {
                if ($rows->column_name == "vat") {
                    $query->leftJoin('vat', '`vat`.`id`= `s_nomenclature_product`.`is_vat`');
                    $sort = 'vat.name';
                } else if ($rows->column_name == "manufacturer_name") {
                    $query->leftJoin('manufacturer', '`manufacturer`.`id`= `s_nomenclature_product`.`manufacturer`');
                    $sort = 'manufacturer.name';
                } else if ($rows->column_name == "manufacturer_name") {
                    $query->leftJoin('manufacturer', '`manufacturer`.`id`= `s_nomenclature_product`.`manufacturer`');
                    $sort = 'manufacturer.name';
                } else if ($rows->column_name == "expenditure_article_name") {
                    $query->leftJoin('expenditure_article', '`expenditure_article`.`id`= `s_nomenclature_product`.`expenditure_article`');
                    $sort = 'expenditure_article.name';
                } else if ($rows->column_name == "expenditure_article_name") {
                    $query->leftJoin('expenditure_article', '`expenditure_article`.`id`= `s_nomenclature_product`.`expenditure_article`');
                    $sort = 'expenditure_article.name';
                } else if ($rows->column_name == "group") {
                    $sort = 's_group_product.name';
                } else if ($rows->column_name == "count") {
                    $query->leftJoin('s_product', 's_product.nomenclature_product_id = `s_nomenclature_product`.`id`');
                    $query->select(['SUM(count) as count_', '`s_nomenclature_product`.*']);
                    $query->groupBy('s_nomenclature_product.id');
                    $sort = 'count_';
                } else if ($rows->column_name == "qty_type") {
                    $query->leftJoin('s_qty_type', '`s_qty_type`.`id`= `s_nomenclature_product`.`qty_type_id`');
                    $sort = 's_qty_type.type';
                }
            } else {
                $sort = $rows->column_name;
            }
        }
        if ($sort) {
            $query->orderBy([$sort => ($rows->direction == "DESC" ? SORT_DESC : SORT_ASC)]);
        }

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