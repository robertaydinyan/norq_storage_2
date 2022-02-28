<?php

namespace app\modules\billing\models;

use omgdef\multilingual\MultilingualBehavior;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $city_type
 * @property int|null $city_type_id
 * @property string|null $lat
 * @property string|null $lng
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_type_id'], 'integer'],
            [['name', 'city_type', 'lat', 'lng'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'city_type' => Yii::t('app', 'City Type'),
            'city_type_id' => Yii::t('app', 'City Type ID'),
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
        ];
    }

    public function behaviors()
    {
        return [

            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->params['languages'],
                'requireTranslations' => 'true',
                'defaultLanguage' => 'ru',
                'langForeignKey' => 'parent_id',
                'tableName' => "{{%cities_lang}}",
                'attributes' => [
                    'name'
                ]
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion() {
        return $this->hasOne(Regions::className(), ['id' => 'region_id']);
    }

     public static  function getCitiesTable () {
         $sql = "SELECT ct.city_type , ct.name as ctname, r.name as rName, cs.name as csName FROM cities as ct
                LEFT JOIN regions as r ON ct.region_id = r.id
                LEFT JOIN countries as cs ON r.country_id = cs.id
                ";

         $tar = Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_OBJ);

//         return ArrayHelper::map($tar);
         return $tar;
     }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getList() {
        return self::find()->all();
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getByRegionId($id) {
        return self::find()->where(['region_id' => $id])->all();
    }


}
