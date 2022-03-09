<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_complectation".
 *
 * @property int $id
 * @property float|null $price
 * @property string|null $name
 * @property int|null $count
 * @property string|null $created_at
 * @property int|null $warehouse_id
 */
class Complectation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_complectation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['count', 'warehouse_id'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => Yii::t('app', 'Cost'),
            'name' => Yii::t('app', 'Name'),
            'count' => Yii::t('app', 'Count'),
            'created_at' => Yii::t('app', 'Date of creation'),
            'warehouse_id' => Yii::t('app', 'Warehouse'),
        ];
    }
}
