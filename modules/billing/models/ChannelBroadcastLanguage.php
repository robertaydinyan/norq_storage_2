<?php

namespace app\modules\billing\models;

use Yii;

/**
 * This is the model class for table "channel_broadcast_language".
 *
 * @property int $id
 * @property string|null $name
 */
class ChannelBroadcastLanguage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'channel_broadcast_language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    public static function getLastId()
    {
        return self::find()->select('id')->orderBy(['id' => SORT_DESC])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
        ];
    }

    public static function getChannelBroadcastLanguage()
    {
        return  ChannelBroadcastLanguage::find()->all();
    }
}
