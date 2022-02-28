<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_complectation_shipping".
 *
 * @property int $id
 * @property int|null $n_product_count
 * @property int $complectation_id
 * @property int $product_id
 */
class ComplectationShipping extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_complectation_shipping';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['n_product_count', 'complectation_id', 'product_id'], 'integer'],
            [['complectation_id', 'product_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'n_product_count' => 'N Product Count',
            'complectation_id' => 'Complectation ID',
            'product_id' => 'Product ID',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
    public function getComplectation()
    {
        return $this->hasOne(Complectation::class, ['id' => 'complectation_id']);
    }
}
