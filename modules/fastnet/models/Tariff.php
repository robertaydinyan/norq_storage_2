<?php

namespace app\modules\fastnet\models;

use app\modules\billing\models\Cities;
use app\modules\billing\models\TvPacket;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "f_tariff".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $availability
 * @property int|null $inet_speed
 * @property int|null $inet_speed_download
 * @property float|null $inet_price
 * @property int|null $tv_id
 * @property int|null $ip_count
 * @property int|null $speed_for_year
 * @property int|null $status
 * @property int|null $type 0 => tan hamar, 1 => bussiness
 * @property string|null $create_at
 * @property string|null $update_at
 */
class Tariff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_tariff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['availability', 'inet_speed','inet_speed_download','old_tariff', 'tv_id', 'ip_count', 'type', 'speed_for_year','status'], 'integer'],
            [['inet_price'], 'number'],
            [['create_at', 'update_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Անվանում',
            'availability' => 'Հասանելիություն',
            'inet_speed' => 'Ինտերնետի արագություն (Upload)',
            'inet_speed_download' => 'Ինտերնետի արագություն (Download)',
            'speed_for_year' => 'Ինտերնետի արագությունը 1 տարով բաժանորդագրվելու դեպքում',
            'inet_price' => 'Գին',
            'tv_id' => 'Հեռուստատեսային փաթեթ',
            'ip_count' => 'IP քանակ',
            'type' => 'Տիպ',
            'old_tariff' => 'Հին',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity(){
        return $this->hasOne(Cities::className(), ['id' => 'availability']);
    }

    public function getTv(){
        return $this->hasOne(TvPacket::className(), ['id' => 'tv_id']);
    }


    /**
     * @return array
     */
    public function tvPacket() {
        return ArrayHelper::map(TvPacket::find()->all(), 'id', function($model){
            return $model->name.'/'.$model->price;
        });
    }

    /**
     * @return array
     */
    public function getType()
    {
        return [Yii::t('app', 'Տան համար'), Yii::t('app', 'Բիզնեսի համար')];
    }

    public function getCities(){
        return ArrayHelper::map(Cities::find()->where(['in', 'id', [37, 38]])->all(), 'id', 'name');
    }
}
