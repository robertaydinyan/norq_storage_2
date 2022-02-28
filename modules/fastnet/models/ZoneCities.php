<?php

namespace app\modules\fastnet\models;

use Yii;

/**
 * This is the model class for table "f_zone_cities".
 *
 * @property int $id
 * @property int|null $zone_id
 * @property int|null $city_id
 */
class ZoneCities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_zone_cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zone_id', 'city_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'zone_id' => 'Zone ID',
            'city_id' => 'City ID',
        ];
    }
}
