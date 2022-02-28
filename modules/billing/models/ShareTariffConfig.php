<?php

namespace app\modules\billing\models;

use Yii;

/**
 * This is the model class for table "b_share_tariff_config".
 *
 * @property int $share_id
 * @property int $tariff_id
 * @property int|null $share_type 0 => tv-ip-internet, 1 => price, 2 => free month
 * @property int|null $internet_id
 * @property int|null $tv_packet_id
 * @property int|null $ip_address_count
 * @property int|null $share_price_type 0 => %, 1 => price
 * @property float|null $share_price_value
 * @property int|null $free_month
 */
class ShareTariffConfig extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'b_share_tariff_config';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['share_id', 'tariff_id'], 'required'],
            [['share_id', 'tariff_id', 'share_type', 'internet_id', 'tv_packet_id', 'ip_address_count', 'share_price_type', 'free_month'], 'integer'],
            [['share_price_value'], 'number'],
            [['share_id', 'tariff_id'], 'unique', 'targetAttribute' => ['share_id', 'tariff_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'share_id' => Yii::t('app', 'Share ID'),
            'tariff_id' => Yii::t('app', 'Tariff ID'),
            'share_type' => Yii::t('app', '0 => tv-ip-internet, 1 => price, 2 => free month'),
            'internet_id' => Yii::t('app', 'Internet ID'),
            'tv_packet_id' => Yii::t('app', 'Tv Packet ID'),
            'ip_address_count' => Yii::t('app', 'Ip Address Count'),
            'share_price_type' => Yii::t('app', '0 => %, 1 => price'),
            'share_price_value' => Yii::t('app', 'Share Price Value'),
            'free_month' => Yii::t('app', 'Free Month'),
        ];
    }

    public static function getTariffsByShareId($id)
    {
        $res = ShareTariffConfig::find()->where(['share_id' => $id])->all();
        $tariffs = [];
        if(!empty($res)) {
            foreach ($res as $tariff => $value) {
                $tariffs[$tariff]['tariff_data'] = Tariff::findOne($value->tariff_id);
                $tariffs[$tariff]['tariff_share_data'] = $value;
            }
        }
        return $tariffs;
    }
    public  function getTariffs()
    {
        $res = ShareTariffConfig::find()->where(['share_id' => $this->id])->all();
        return $res;
    }
    public function getServiceId()
    {
        return  Share::find()->select('service_id')->where(['id' => $this->share_id])->one();
    }
}
