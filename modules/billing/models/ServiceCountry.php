<?php

namespace app\modules\billing\models;

use Yii;

/**
 * This is the model class for table "service_country".
 *
 * @property int $service_id
 * @property int $country_id
 * @property int $region_id
 * @property int $city_id
 */
class ServiceCountry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'country_id', 'region_id', 'city_id'], 'required'],
            [['service_id', 'country_id', 'region_id', 'city_id'], 'integer'],
            [['service_id', 'country_id', 'region_id', 'city_id'], 'unique', 'targetAttribute' => ['service_id', 'country_id', 'region_id', 'city_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'service_id' => Yii::t('app', 'Service ID'),
            'country_id' => Yii::t('app', 'Country ID'),
            'region_id' => Yii::t('app', 'Region ID'),
            'city_id' => Yii::t('app', 'City ID'),
        ];
    }
}
