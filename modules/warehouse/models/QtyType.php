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
            [['type', 'type_ru', 'type_us'], 'required'],
            [['type', 'type_ru', 'type_us'], 'string', 'max' => 255],
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
            'type_us' => Yii::t('app', 'Unit of measurement(American)'),
        ];
    }

}
