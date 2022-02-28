<?php

namespace app\modules\billing\models;

use Yii;

/**
 * This is the model class for table "channel_quality".
 *
 * @property int $id
 * @property string|null $name
 */
class ChannelQuality extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'channel_quality';
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

    public static function getChannelQuality()
    {
        return  ChannelQuality::find()->all();
    }
    public static function getLastId()
    {
        return self::find()->select('id')->orderBy(['id' => SORT_DESC])->one();
    }
}
