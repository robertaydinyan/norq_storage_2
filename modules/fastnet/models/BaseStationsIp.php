<?php

namespace app\modules\fastnet\models;

use app\modules\billing\models\IpAddresses;
use Yii;

/**
 * This is the model class for table "base_stations_ip".
 *
 * @property string|null $deal_number
 * @property int $ip_id
 */
class BaseStationsIp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'base_stations_ip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deal_number', 'ip_id'], 'required'],
            [['ip_id'], 'integer'],
            [['deal_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'deal_number' => 'Deal Number',
            'ip_id' => 'Ip ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeals()
    {
        return $this->hasOne(Deal::className(), ['deal_number' => 'deal_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIpAddress()
    {
        return $this->hasOne(IpAddresses::className(), ['id' => 'ip_id']);
    }
}
