<?php

namespace app\modules\billing\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tv_channel".
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $cost_price
 * @property float|null $amount
 * @property int|null $active
 * @property int|null $password
 */
class TvChannel extends ActiveRecord
{

    public $broadcast_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tv_channel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cost_price', 'amount'], 'number'],
            [['active', 'password', 'channel_quality_id','channel_category_id' ,'provider_id','broadcast_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['logo_channel'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,jpeg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            if(isset($this->logo_channel->baseName) && !empty($this->logo_channel->baseName)) {
                $this->logo_channel->saveAs('uploads/' . $this->logo_channel->baseName . '.' . $this->logo_channel->extension);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Наименование'),
            'cost_price' => Yii::t('app', 'Себестоимость'),
            'amount' => Yii::t('app', 'Количество'),
            'active' => Yii::t('app', 'Активный'),
            'password' => Yii::t('app', 'Пароль'),
        ];
    }
    public static function getLastId()
    {
        return self::find()->select('id')->orderBy(['id' => SORT_DESC])->one();
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
                'tableName' => "{{%tv_channel_lang}}",
                'attributes' => [
                    'name'
                ]
            ],
        ];
    }
    public static function getChannels () {
        return self::find()->asArray()->where(['active' => 1])->all();
    }
    /**
     * @return MultilingualQuery|ActiveQuery
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }
}
