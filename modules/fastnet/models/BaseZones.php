<?php

namespace app\modules\fastnet\models;

use Yii;

/**
 * This is the model class for table "base_zones".
 *
 * @property int|null $base_id
 * @property int|null $zone_id
 */
class BaseZones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_base_zones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['base_id', 'zone_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'base_id' => 'Base ID',
            'zone_id' => 'Zone ID',
        ];
    }
}
