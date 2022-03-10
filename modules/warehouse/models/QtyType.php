<?php


namespace app\modules\warehouse\models;


use Yii;

class QtyType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_qty_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_hy', 'type_ru', 'type_en'], 'required'],
            [['type_hy', 'type_ru', 'type_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_hy' => Yii::t('app', 'Unit of measurement(Armenian)'),
            'type_ru' => Yii::t('app', 'Unit of measurement(Russian)'),
            'type_en' => Yii::t('app', 'Unit of measurement(English)'),
        ];
    }

}
