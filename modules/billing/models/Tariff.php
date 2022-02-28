<?php

namespace app\modules\billing\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "tariff".
 *
 * @property int $id
 * @property string $name
 * @property int|null $is_internet
 * @property int|null $internet_type 0 => speed, 1 => traffic volume
 * @property int|null $internet_id
 * @property int|null $is_tv
 * @property int|null $tv_packet_id
 * @property int|null $is_ip
 * @property int|null $ip_count
 * @property int|null $actual_price
 * @property int|null $actual_price_type
 * @property int $is_active
 * @property string|null $create_at
 * @property string|null $update_at
 */
class Tariff extends \yii\db\ActiveRecord
{

    const Type = [
        2 => 'Скорость',
        1 => 'Пакет',
    ];

    const ActualPriceType = [
        1 => '%',
        2 => 'Драм',
    ];

    public $hiddenActualPrice;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tariff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['internet_type', 'internet_id', 'tv_packet_id', 'ip_count', 'actual_price_type', 'is_active'], 'integer'],
            [['actual_price'], 'number'],
            [['is_internet', 'is_tv', 'is_ip', 'create_at', 'update_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Наименование'),
            'is_internet' => Yii::t('app', 'Интернет'),
            'internet_type' => Yii::t('app', 'Интернет Тип'),
            'internet_id' => Yii::t('app', 'Интернет'),
            'is_tv' => Yii::t('app', 'TV'),
            'tv_packet_id' => Yii::t('app', 'ТВ-пакет'),
            'is_ip' => Yii::t('app', 'IP адрес'),
            'ip_count' => Yii::t('app', 'Количество IP адресов'),
            'actual_price' => Yii::t('app', 'Настоящая цена'),
            'actual_price_type' => Yii::t('app', 'Тип фактической цены'),
            'is_active' => Yii::t('app', 'Активен'),
            'create_at' => Yii::t('app', 'Создано'),
            'update_at' => Yii::t('app', 'Обновлено'),
        ];
    }

    /**
     * @return array|array[]
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT => ['create_at', 'update_at'],
                    self::EVENT_BEFORE_UPDATE => 'update_at',
                ],
                'value' => new Expression('NOW()'),
            ],
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->params['languages'],
                'requireTranslations' => 'true',
                'defaultLanguage' => 'ru',
                'langForeignKey' => 'parent_id',
                'tableName' => "{{%tariff_lang}}",
                'attributes' => [
                    'name'
                ]
            ],
        ];
    }

    /**
     * @return MultilingualQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInternet()
    {
        return $this->hasOne(Internet::className(), ['id' => 'internet_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIp()
    {
        return $this->hasOne(IpAddresses::className(), ['id' => 'ip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTv()
    {
        return $this->hasOne(TvPacket::className(), ['id' => 'tv_packet_id']);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getTvPackages()
    {
        return TvPacket::find()->all();
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function activeTariffs()
    {
        return Tariff::find()->where(['is_active' => true])->all();
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord|null
     */
    public static function getSelectedInternetType($id)
    {
        return Internet::find()->select('id')->where(['id' => $id])->one();
    }

    /**
     * @param $ids
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getTariffsByIds($ids)
    {
        return Tariff::find()->where(['id' => $ids])->all();
    }

    /**
     * @param $service_id
     * @return mixed|null
     */
    public  function getTariffTotalPrice($service_id)
    {
        return ServiceTariff::find()->select('total_price')->where(['tariff_id' => $this->id,'service_id'=>$service_id])->one()->total_price;
    }

    /**
     * @param $type
     * @return \string[][]
     */
    public static function getInternetByType($type)
    {
        if (!empty($type)) {

            $execute = [];

            if ($type == 1) {
                $typeName = 'size';

                $where = ['IS NOT', 'size', null];

            } else {
                $typeName = 'speed';

                $where = ['IS', 'size', null];
            }
            $internet = Internet::find()->where($where)->all();

            if (!empty($internet)) {

                foreach ($internet as $internetType) {

                    $relatedUnit = $type == 1 ?  $internetType->sizeUnit->name : $internetType->speedUnit->name;
                    $execute[] = ['id' => $internetType['id'], 'text' => $internetType[$typeName] . ' ' . $relatedUnit];
                }
            }
            return $execute;
        }
    }

    /**
     * @param $id
     * @return mixed|string
     */
    public static function getInternetSpeedById($id)
    {
        if (!empty($id)) {
            $internetType =  Internet::find()->where(['id' => $id])->one();
            $typeName = 'size';

            if (!empty($internetType)) {
                $relatedUnit = $internetType->sizeUnit->name;
                return $internetType[$typeName] . ' ' . $relatedUnit;
            } else {
                return $internetType[$typeName];
            }

        }
    }

    /**
     * @param $id
     * @return bool|int|string|null
     */
    public static function getChannelCountById($id)
    {
        if (!empty($id)) {
            return TvPacketChannel::find()->where(['packet_id'=>$id])->count();
        }
    }

    /**
     * @return array|\yii\db\DataReader
     * @throws \yii\db\Exception
     */
    public static function internetSizeSpeedName($type)
    {
        if($type == 1){
            $typeName = 'size';
            $where = 'IS NOT NULL';
        }else{
            $typeName = 'speed';
            $where = 'IS NULL';
        }
        $sql = "SELECT i.id, CONCAT(i." . $typeName . ", ' ', u.name) AS name FROM `internet` AS i
                JOIN units AS u ON i.inet_" . $typeName . "_unit_id = u.id
                WHERE i.size $where";
        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    /**
     * @param null $internet_id
     * @param null $packet_id
     * @param null $ip_count
     * @return bool|float|int|mixed|string
     */
    public static function tariffCostPrice($internet_id = null, $packet_id = null, $ip_count = null){
        $sum = 0;
        $channel = [];

        if($internet_id){
            $sum += Internet::find()->where(['id' => $internet_id])->sum('price');
        }

        if($ip_count){
            $ipPrice = IpAddresses::find()->select('SUM(price) AS total')->asArray()->one()['total'];
            $sum += (floatval($ipPrice) * intval($ip_count));
        }

        if($packet_id){
            $packet = TvPacketChannel::find()->where(['packet_id' => $packet_id])->all();
            foreach ($packet as $item) {
                $channel[] = TvChannel::find()->where(['id' => $item->channel_id])->sum('amount');
            }
        }

        if (!empty($channel)) {
            $totalSum = array_sum($channel) + $sum;
        } else {
            $totalSum = $sum;
        }
        return $totalSum;
    }

    /**
     * @return bool|float|int|mixed|string
     */
    public function tariffCostPriceSimple(){
        $internet_id = $this->internet_id;
        $packet_id = $this->tv_packet_id;
        $ip_count = $this->ip_count;

        $sum = 0;
        $channel = [];

        if($internet_id){
            $sum += Internet::find()->where(['id' => $internet_id])->sum('price');
        }

        if($ip_count){
            $ipPrice = IpAddresses::find()->select('SUM(price) AS total')->asArray()->one()['total'];
            $sum += (floatval($ipPrice) * intval($ip_count));
        }

        if($packet_id){
            $packet = TvPacketChannel::find()->where(['packet_id' => $packet_id])->all();
            foreach ($packet as $item) {
                $channel[] = TvChannel::find()->where(['id' => $item->channel_id])->sum('amount');
            }
        }

        if (!empty($channel)) {
            $totalSum = array_sum($channel) + $sum;
        } else {
            $totalSum = $sum;
        }
        return $totalSum;
    }
    public static function getListForSearch()
    {
        $list =  Tariff::find()->all();
        $new_list = [];
        if(!empty($list)) {
            foreach ($list as $el => $val) {
                $new_list[$el]['value'] = $val->id;
                $new_list[$el]['name'] = $val->name;
            }
        }
        return $new_list;
    }

    /**
     * @return array|\yii\db\ActiveRecord|null
     */
    public static function getLastId()
    {
        return self::find()->select('id')->orderBy(['id' => SORT_DESC])->one();
    }

}
