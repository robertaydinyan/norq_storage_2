<?php

namespace app\modules\fastnet\models;

use Yii;

/**
 * This is the model class for table "f_zone_regions".
 *
 * @property int $id
 * @property int|null $zone_id
 * @property int|null $region_id
 */
class ZoneRegions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_zone_regions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zone_id', 'region_id'], 'integer'],
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
            'region_id' => 'Region ID',
        ];
    }
}
