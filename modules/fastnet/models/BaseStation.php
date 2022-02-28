<?php

namespace app\modules\fastnet\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "f_base_station".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $ip
 * @property string|null $ip_end
 * @property int|null $zona_id
 */
class BaseStation extends \yii\db\ActiveRecord
{

    public $zona_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_base_station';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['zona_id'], 'safe'],
            [['ip', 'ip_end'], 'ip'],
        ];
    }
    const Equipments = [
        1 => 'Սարք 1',
        2 => 'Սարք 2',
        3 => 'Սարք 3',
        4 => 'Սարք 4',
        5 => 'Սարք 5',
        6 => 'Սարք 6',
    ];

    public function getZone()
    {
        return $this->hasMany(Zone::className(), ['id' => 'zone_id'])->viaTable(BaseZones::tableName(), ['base_id' => 'id']);
    }

    /**
     * @return array
     */
    public function selectedZone()
    {
        $selectedZones = [];
        $zoneQuery = BaseZones::find()->where(['base_id' => $this->id])->asArray()->all();

        if (!empty($zoneQuery)) {
            foreach ($zoneQuery as $zone) {
                $selectedZones[] = $zone['zone_id'];
            }
        }

        return $selectedZones;
    }

    /**
     * @return array
     */
    public function selectedZoneName()
    {
        $selectedZones = [];

        if (!empty($this->zone)) {
            foreach ($this->zone as $zone) {
                $selectedZones[] = $zone->name;
            }
        }

        return $selectedZones;
    }

    public function getZona() {
        return  Zone::findOne(['id' => $this->zona_id])->name;
    }

    public function getEquipments() {
        $equipments = BazeStationEquipments::find()->select('equipment_id')->where(['base_id' => $this->id])->all();
        $equipments_list = '';
        if(!empty($equipments)) {
            foreach ($equipments as $equipment => $val) {

                if(BaseStation::Equipments[$val->equipment_id]){
                    $equipments_list.= BaseStation::Equipments[$val->equipment_id].', ';
                }
            }
        }
        return rtrim($equipments_list, ", ");
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Անուն',
            'ip' => 'Ip (սկիզբ)',
            'ip_end' => 'Ip (վերջ)',
            'zona_id' => 'Գոտի',
            'equipment_id' => 'Սարքավորումներ',
        ];
    }

    public static function all(){
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeal() {
        return $this->hasMany(Deal::className(), ['base_station_id' => 'id']);
    }
}
