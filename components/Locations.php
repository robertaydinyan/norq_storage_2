<?php

namespace app\components;

use app\modules\billing\models\Cities;
use app\modules\billing\models\Community;
use app\modules\billing\models\Regions;
use app\modules\fastnet\models\Streets;

class Locations
{

    /**
     * @param int $id
     * @return array
     */
    public static function renderRegions($id = 1) {
        $regions = Regions::find();

        if (is_array($id)) {
            $regions->where(['in', 'country_id', $id]);
        } else {
            $regions->where(['country_id' => $id]);
        }

        return self::buildOptions($regions->all());
    }

    /**
     * @param $id
     * @return array
     */
    public static function renderCities($id) {

        if (is_null($id)) {
            return [];
        }

        $cities = Cities::find();

        if (is_array($id)) {
            $cities->where(['in', 'region_id', $id]);
        } else {
            $cities->where(['region_id' => $id]);
        }

        return self::buildOptions($cities->all());
    }

    /**
     * @param $id
     * @return array
     */
    public static function renderCommunities($id) {

        if (is_null($id)) {
            return [];
        }

        $communities = Community::find();

        if (is_array($id)) {
            $communities->where(['in', 'city_id', $id]);
        } else {
            $communities->where(['city_id' => $id]);
        }

        return self::buildOptions($communities->all());
    }

    /**
     * @param $id
     * @return array
     */
    public static function renderStreets($id) {

        if (is_null($id)) {
            return [];
        }

        $streets = Streets::find();

        if (is_array($id)) {
            $streets->where(['in', 'city_id', $id]);
        } else {
            $streets->where(['city_id' => $id]);
        }

        return self::buildOptions($streets->all());
    }

    /**
     * @param array $array
     * @param $id
     * @param $text
     * @return array
     */
    public static function buildOptions(array $array) {
        $options = [];

        foreach ($array as $option) {
            $options[] = ['id' => $option['id'], 'text' => $option['name']];
        }

        return $options;
    }

}