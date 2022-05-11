<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "vat".
 *
 * @property int $id
 * @property string $name
 * @property string $formula
 * @property integer $isDeleted
 */
class Vat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'formula'], 'required'],
            [['name', 'formula'], 'string', 'max' => 255],
            [['isDeleted'], 'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Անուն',
            'formula' => 'Բանաձև',
            'isDeleted' => 'isDeleted',
        ];
    }
}
