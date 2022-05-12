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
            [['type',], 'required'],
            [['type',], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => Yii::t('app', 'Unit of measurement'),
        ];
    }
    public function attributeLabelsAll()
    {
        return [
            'id' => 'ID',
            'type' => Yii::t('app', 'Unit of measurement'),
        ];
    }

}
