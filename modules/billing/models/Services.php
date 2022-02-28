<?php

namespace app\modules\billing\models;

use app\modules\crm\models\Deal;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $services_client_type
 * @property int|null $payment_type
 * @property int|null $payment_period
 * @property int|null $random
 */
class Services extends \yii\db\ActiveRecord
{
    public $tarif_id;
    public $service_id;
    public $country_id;
    public $region_id;
    public $city_id;
    public $product_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['services_client_type', 'payment_type', 'payment_period', 'random'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['tarif_id', 'service_id', 'country_id', 'region_id', 'city_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Название'),
            'services_client_type' => Yii::t('app', 'Тип клиента'),
            'payment_type' => Yii::t('app', 'Способ оплаты'),
            'payment_period' => Yii::t('app', 'Период оплаты'),
            'random' => Yii::t('app', 'Случайный'),
            'country_id' => Yii::t('app', 'Страна'),
            'region_id' => Yii::t('app', 'Область'),
            'city_id' => Yii::t('app', 'Город'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getTariff() {
        return  $this->hasMany(Tariff::className(), ['id' => 'tariff_id'])->viaTable('service_tariff', ['service_id' => 'id']);
    }
    public function getAddressData() {
        return  $this->hasOne(ServiceCountry::className(), ['service_id' => 'id']);
    }
    /**
     * @return array
     */
    public static function getAllCountries()
    {
        return ArrayHelper::map(Countries::find()->all(), 'id', 'name');
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getRegionsByCountry($id)
    {

        return ArrayHelper::map(Regions::find()->where(['country_id' => $id])->all(), 'id', 'name');
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getCitiesByRegion($id)
    {
        return Cities::find()->where(['region_id' => $id])->all();
    }

    /**
     * @param $id
     * @param $service_id
     * @return array|\yii\db\ActiveRecord|null
     */
    public static function getSelectedCountry($id, $service_id)
    {
        return ServiceCountry::find()->select('country_id')->where(['country_id' => $id])->andWhere(['service_id' => $service_id])->one();
    }

    /**
     * @param $ids
     * @return array
     */
    public static function getServicesByIds($ids)
    {
        $res = Services::find()->where(['id' => $ids])->all();
        return ArrayHelper::map($res,'id', 'name');
    }
    public  function getClients()
    {
        return Deal::find()->where(['service_id' => $this->id])->groupBy('name')->all();
    }

    public static function getListForSearch()
    {
        $list =  Services::find()->all();
        $new_list = [];
        if(!empty($list)) {
            foreach ($list as $el => $val) {
                $new_list[$el]['value'] = $val->id;
                $new_list[$el]['name'] = $val->name;
            }
        }
        return $new_list;
    }
    public static function getLastId()
    {
        return self::find()->select('id')->orderBy(['id' => SORT_DESC])->one();
    }
}
