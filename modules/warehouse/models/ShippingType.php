<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_shipping_type".
 *
 * @property int $id
 * @property string $name
 */
class ShippingType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_shipping_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
            'name' => 'Անվանում',
        ];
    }
}
