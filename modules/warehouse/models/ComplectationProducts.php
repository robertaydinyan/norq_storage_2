<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_complectation_products".
 *
 * @property int $id
 * @property int|null $n_product_count
 * @property int $complectation_id
 * @property int $numiclature_id
 * @property int $price
 */
class ComplectationProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_complectation_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['n_product_count', 'complectation_id','numiclature_id','price'], 'integer'],
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
            'n_product_count' => Yii::t('app', 'Count'),
            'complectation_id' => 'Complectation ID',
        ];
    }
 
    public function getNProduct()
    {
        return $this->hasOne(NomenclatureProduct::class, ['id' => 'numiclature_id']);
    }
}
