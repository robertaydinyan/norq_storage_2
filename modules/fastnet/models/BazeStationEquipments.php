<?php

namespace app\modules\fastnet\models;

use Yii;

/**
 * This is the model class for table "f_baze_station_equipments".
 *
 * @property int $id
 * @property int|null $base_id
 * @property int|null $equipment_id
 */
class BazeStationEquipments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_baze_station_equipments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['base_id', 'equipment_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'base_id' => 'Base ID',
            'equipment_id' => 'Equipment ID',
        ];
    }
}
