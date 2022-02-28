<?php

namespace app\modules\warehouse\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\warehouse\models\ShippingProduct;

/**
 * ShippingProductSearch represents the model behind the search form of `app\modules\warehouse\models\ShippingProduct`.
 */
class ShippingProductSearch extends ShippingProduct
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'shipping_id', 'product_id'], 'integer'],
            [['created_at'], 'safe'],
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
    public function search($params , $shipping_id = null)
    {
        if ($shipping_id === null) {
            $query = ShippingProduct::find();
        } else {
            $query = ShippingProduct::find()->where(['shipping_id' => $shipping_id]);
        }

//        if (Yii::$app->user->identity->username === 'ashotfast') {
//            $query = ShippingProduct::find();
//        } else {
//            $query = ShippingProduct::find();
//        }
        //$query = ShippingProduct::find();

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
            'created_at' => $this->created_at,
            'shipping_id' => $this->shipping_id,
            'product_id' => $this->product_id,
        ]);

        return $dataProvider;
    }
}
