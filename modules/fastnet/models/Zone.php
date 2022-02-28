<?php

namespace app\modules\fastnet\models;

use app\modules\billing\models\Cities;
use app\modules\billing\models\Community;
use app\modules\billing\models\Countries;
use app\modules\billing\models\Regions;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "f_zone".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $country_id
 * @property int|null $region_id
 */
class Zone extends \yii\db\ActiveRecord
{
    public $region_id;

    public $city_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_zone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_id', 'region_id', 'city_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Անուն',
            'country_id' => 'Երկիր',
            'region_id' => 'Մարզ',
            'city_id' => 'Շրջան',
            'community_id' => 'Համայնք',
            'street_id' => 'Փողոց',
        ];
    }

    public function getCity() {
        $cities = ZoneCities::find()->where(['zone_id' => $this->id])->all();
        $city_list = '';
        if(!empty($cities)) {
            foreach ($cities as $city => $val) {
               $city = Cities::findOne(['id'=>$val['city_id']]);
               if($city){
                   $city_list.= $city['name'].',';
               }
            }
        }
        return rtrim($city_list, ", ");
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCities() {
        $cities = ZoneCities::find()->select('city_id')->where(['zone_id'=>$this->id])->all();
        $cities_arr = [];
        if(!empty($cities)){
            foreach ($cities as $city => $val){
                array_push($cities_arr,$val->city_id);
            }
            $cities['list'] = ArrayHelper::map(Cities::find()->where(['id'=>$cities_arr])->all(), 'id', 'name');
            $cities['vals'] = $cities_arr;
            return $cities;
        }

        return [];
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getRegions() {
        $regions = ZoneRegions::find()->select('region_id')->where(['zone_id' => $this->id])->all();
        $regions_arr = [];
        foreach ($regions as $region => $val) {
            array_push($regions_arr, $val->region_id);
        }
        $regions['list'] = ArrayHelper::map(Regions::find()->all(), 'id', 'name');
        $regions['vals'] = $regions_arr;
        return $regions;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCommunities() {
        $communities = ZoneCommunity::find()->select('community_id')->where(['zone_id' => $this->id])->all();
        $communities_arr = [];
        foreach ($communities as $val) {
            array_push($communities_arr, $val->community_id);
        }
        $communities['list'] = ArrayHelper::map(Community::find()->all(), 'id', 'name');
        $communities['vals'] = $communities_arr;
        return $communities;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getStreets() {
        $streets = ZoneStreet::find()->select('street_id')->where(['zone_id' => $this->id])->all();
        $streets_arr = [];
        foreach ($streets as $val) {
            array_push($streets_arr, $val->street_id);
        }
        $streets['list'] = ArrayHelper::map(Streets::find()->all(), 'id', 'name');
        $streets['vals'] = $streets_arr;
        return $streets;
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getZoneRegions() {
        return $this->hasMany(Regions::className(), ['id' => 'region_id'])
            ->viaTable(ZoneRegions::tableName(), ['zone_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getZoneCities() {
        return $this->hasMany(Cities::className(), ['id' => 'city_id'])
            ->viaTable(ZoneCities::tableName(), ['zone_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getZoneCommunities() {
        return $this->hasMany(Community::className(), ['id' => 'community_id'])
            ->viaTable(ZoneCommunity::tableName(), ['zone_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getZoneStreets() {
        return $this->hasMany(Streets::className(), ['id' => 'street_id'])
            ->viaTable(ZoneStreet::tableName(), ['zone_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZoneCountries() {
        return $this->hasOne(Countries::className(), ['id' => 'country_id']);
    }

    /**
     * @return string|null
     */
    public function getRegion() {
        return Regions::findOne(['id' => $this->region_id])->name;
    }

    /**
     * @return string|null
     */
    public function getCountry() {
        return Countries::findOne(['id' => $this->country_id])->name;
    }

    /**
     * @param $cities
     * @param $regions
     * @param $communities
     * @param $streets
     * @param false $updateMode
     * @return bool
     */
    public function saveLocation($cities, $regions, $communities, $streets, $updateMode = false) {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (!empty($regions)) {
                if ($updateMode) {
                    ZoneRegions::deleteAll(['zone_id' => $this->id]);
                }

                foreach ($regions as $region) {
                    $zoneRegion = new ZoneRegions();
                    $zoneRegion->region_id = $region;
                    $zoneRegion->zone_id = $this->id;
                    $zoneRegion->save();
                }
            }

            if (!empty($cities)) {
                if ($updateMode) {
                    ZoneCities::deleteAll(['zone_id' => $this->id]);
                }

                foreach ($cities as $city) {
                    $city_zone = new ZoneCities();
                    $city_zone->city_id = $city;
                    $city_zone->zone_id = $this->id;
                    $city_zone->save();
                }
            }

            if (!empty($communities)) {
                if ($updateMode) {
                    ZoneCommunity::deleteAll(['zone_id' => $this->id]);
                }

                foreach ($communities as $community) {
                    $zoneCommunity = new ZoneCommunity();
                    $zoneCommunity->community_id = $community;
                    $zoneCommunity->zone_id = $this->id;
                    $zoneCommunity->save();
                }
            }

            if (!empty($streets)) {
                if ($updateMode) {
                    ZoneStreet::deleteAll(['zone_id' => $this->id]);
                }

                foreach ($streets as $street) {
                    $zoneStreet = new ZoneStreet();
                    $zoneStreet->street_id = $street;
                    $zoneStreet->zone_id = $this->id;
                    $zoneStreet->save();
                }
            }

            $transaction->commit();
            return true;
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return false;
        }
    }
}
