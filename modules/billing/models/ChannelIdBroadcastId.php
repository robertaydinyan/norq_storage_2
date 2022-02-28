<?php

namespace app\modules\billing\models;

use Yii;

/**
 * This is the model class for table "channel_id_broadcast_id".
 *
 * @property int $id
 * @property int|null $channel_id
 * @property int|null $broadcast_id
 */
class ChannelIdBroadcastId extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'channel_id_broadcast_id';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['channel_id', 'broadcast_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel_id' => 'Channel ID',
            'broadcast_id' => 'Broadcast ID',
        ];
    }
}
