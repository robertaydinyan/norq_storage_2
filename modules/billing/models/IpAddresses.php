<?php

namespace app\modules\billing\models;

use app\modules\fastnet\models\BaseStation;
use app\modules\fastnet\models\BaseStationsIp;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ip_addresses".
 *
 * @property int $id
 * @property string|null $address
 * @property int|null $status
 * @property int|null $base_id
 * @property float|null $price
 */
class IpAddresses extends \yii\db\ActiveRecord
{

    public $text;

    const ipStatusColor = [
        0 => ['status'=> 'Պասիվ','color' => '#ccc'],
        1 => ['status'=> 'Ակտիվ', 'color' => '#25AF36'],
        2 => ['status'=> 'Ընթացքում', 'color' => '#FAE000'],
        3 => ['status'=> 'Զբաղված ', 'color' => '#F23737'],
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ip_addresses';
    }

    /**
     * @return array|\yii\db\ActiveRecord|null
     */
    public static function getLastId()
    {
        return self::find()->select('id')->orderBy(['id' => SORT_DESC])->one();
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['base_id'], 'integer'],
            ['address', 'ip'], // IPv4 or IPv6 address
            ['address', 'unique'], // IPv4 or IPv6 address
            ['address', 'ip', 'ipv6' => false], // IPv4 address (IPv6 is disabled)
            //['address', 'ip', 'expandIPv6' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'base_id' => Yii::t('app', 'Բազային կայան'),
            'address' => Yii::t('app', 'Address'),
            'status' => Yii::t('app', 'Status'),
            'price' => Yii::t('app', 'Price'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaseStationIp()
    {
        return $this->hasOne(BaseStationsIp::className(), ['ip_id' => 'id']);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAllContent(){
        return self::find()->all();
    }

    /**
     * @param int $baseStation
     * @param false $multiple
     * @return array
     */
    public static function filterIpAddresses($baseStation = 1, $multiple = false) {
        $ipList = static::find();

        if ($multiple) {
            if (is_null($baseStation)) {
                $baseStation = [1];
            }

            $ipList->where(['in', 'base_id', $baseStation]);
        } else {
            $ipList->where(['base_id' => $baseStation]);
        }

        $groupedIpAddresses = [];
        foreach ($ipList->each() as $address) {
            $groupedIpAddresses[$address->base_id][] = $address;
        }

        return $groupedIpAddresses;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getTvChannels()
    {
        return  TvChannel::find()->all();
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getTvPackets()
    {
        return  TvPacket::find()->all();
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getInternet()
    {
        return  Internet::find()->all();
    }

    /**
     * @param false $disabled
     * @return \string[][]
     */
    public static function getIpStatusColor($disabled = false){
        $arr = self::ipStatusColor;
        if($disabled){
            unset($arr[3]);
        }
            return $arr;
    }

    /**
     * @return array
     */
    public static function getActiveIps(){
        $res = self::find()->where(['status'=>1])->all();
        return ArrayHelper::map($res, 'id', 'address');
    }

    /**
     * @param null $bs_id
     * @param array $update
     * @return array
     */

    public static function all($bs_id, $update = []){
        $ip = IpAddresses::find()->where(['base_id' => $bs_id])->andWhere(['status' => 1]);

        if(!empty($update)) {
            $ip->orWhere(['in', 'id', $update]);
        }

        $options = [];

        if (!empty($ip->all())) {
            foreach ($ip->all() as $option) {
                $options[] = ['id' => $option['id'], 'text' => $option['address']];
            }
        }
        return $options;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function baseStationList() {
        return BaseStation::find()->all();
    }

    /**
     * @param $id
     * @param $status
     * @return bool
     */
    public static function IPAddressStatus($id, $status)
    {
        $ipAddresses = static::findOne((int) $id);
        $ipAddresses->status = $status;

        if ($ipAddresses->save()) {
            return true;
        }

        return $ipAddresses->errors;
    }

}
