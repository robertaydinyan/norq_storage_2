<?php

namespace app\modules\billing\models;

use Yii;

/**
 * This is the model class for table "tv_packet_channel".
 *
 * @property int $packet_id
 * @property int $channel_id
 * @property int|null $price
 */
class TvPacketChannel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tv_packet_channel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['packet_id', 'channel_id'], 'required'],
            [['packet_id', 'channel_id', 'price'], 'integer'],
            [['packet_id', 'channel_id'], 'unique', 'targetAttribute' => ['packet_id', 'channel_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'packet_id' => Yii::t('app', 'Packet ID'),
            'channel_id' => Yii::t('app', 'Channel ID'),
            'price' => Yii::t('app', 'Price'),
        ];
    }
}
