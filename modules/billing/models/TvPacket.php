<?php

namespace app\modules\billing\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tv_packet".
 *
 * @property int $id
 * @property string|null $name
 */
class TvPacket extends ActiveRecord
{
    public $tv_channel;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tv_packet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['tv_channel', 'price'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Имя'),
            'price' => Yii::t('app', 'Цена'),
        ];
    }


    public static function getChannels () {
        return TvChannel::find()->where(['active' => 1])->all();
    }

    /**
     * @return array|array[]
     */
    public function behaviors()
    {
        return [

            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->params['languages'],
                'requireTranslations' => 'true',
                'defaultLanguage' => 'ru',
                'langForeignKey' => 'parent_id',
                'tableName' => "{{%tv_packet_lang}}",
                'attributes' => [
                    'name'
                ]
            ],
        ];
    }

    public static function getLastId()
    {
        return self::find()->select('id')->orderBy(['id' => SORT_DESC])->one();
    }

    /**
     * @return MultilingualQuery|ActiveQuery
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }
}
