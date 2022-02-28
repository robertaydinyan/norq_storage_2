<?php

namespace app\modules\billing\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "internet".
 *
 * @property int $id
 * @property int|null $speed
 * @property int|null $inet_speed_unit_id
 * @property int|null $size
 * @property int|null $inet_size_unit_id
 * @property int|null $price
 */
class Internet extends \yii\db\ActiveRecord
{
    public $unit;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'internet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['speed', 'inet_speed_unit_id', 'size', 'inet_size_unit_id', 'min_speed' , 'inet_min_speed_unit_id' ,'reset_speed_type' , 'reset_speed' , 'reset_speed_unit_id' , 'size_empty_type'], 'integer'],
            [['price'], 'number'],
        ];
    }

    public static function getUnitsSpeed () {
        return Units::find()->asArray()->where(['type' => 1])->all();
    }

    public static function getLastId()
    {
        return self::find()->select('id')->orderBy(['id' => SORT_DESC])->one();
    }

    public static function getUnitsSize () {
        return Units::find()->asArray()->where(['type' => 2])->all();
    }

        /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'speed' => Yii::t('app', 'Скорость'),
            'inet_speed_unit_id' => Yii::t('app', 'Единица скорости Интернета'),
            'size' => Yii::t('app', 'Размер'),
            'inet_size_unit_id' => Yii::t('app', 'Единица размера Интернета'),
            'price' => Yii::t('app', 'Цена'),
            'min_speed' => Yii::t('app', 'Мин. Скорость'),
            'inet_min_speed_unit_id' => Yii::t('app', 'Мин. Скорость Интернета'),
            'reset_speed_type' => Yii::t('app', 'Сбросить тип скорости'),
            'reset_speed' => Yii::t('app', 'Сбросный скорость'),
            'reset_speed_unit_id' => Yii::t('app', 'Сброс единиц скорости'),
            'size_empty_type' => Yii::t('app', 'Размер пустой тип'),

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpeedUnit()
    {
        return $this->hasOne(Units::className(), ['id' => 'inet_speed_unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSizeUnit()
    {
        return $this->hasOne(Units::className(), ['id' => 'inet_size_unit_id']);
    }

}
