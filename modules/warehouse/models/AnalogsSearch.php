<?php

namespace app\modules\warehouse\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\warehouse\models\Analogs;

/**
 * AnalogsSearch represents the model behind the search form of `app\modules\warehouse\models\Analogs`.
 */
class AnalogsSearch extends Analogs
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'analog_id'], 'integer'],
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
    public function search($article , $rows = '')
    {
        $query = Analogs::find();

        // add conditions that should always apply here
        if ($article) {
            $query->andWhere(['like', 'article', $article]);
        }

        if (isset($rows) && $rows->column_name) {

            if (!$this->hasAttribute($rows->column_name)) {

                if ($rows->column_name == "product_id") {
                    $query->leftJoin('s_nomenclature_product', '`s_nomenclature_product`.`id`= `s_analogs`.`product_id`');
                    $sort = 's_nomenclature_product.vendor_code';
                } elseif ($rows->column_name == "analog_id") {

                    $query->leftJoin('s_nomenclature_product', '`s_nomenclature_product`.`id`= `s_analogs`.`analog_id`');
                    $sort = 's_nomenclature_product.name';
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

        $this->load($article);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'analog_id' => $this->analog_id,
        ]);

        return $dataProvider;
    }
}
