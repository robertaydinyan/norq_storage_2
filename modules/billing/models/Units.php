<?php

namespace app\modules\billing\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;

/**
 * This is the model class for table "units".
 *
 * @property int $id
 * @property string|null $name
 */
class Units extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'units';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['type'], 'integer'],
        ];
    }
    public static function getLastId()
    {
        return self::find()->select('id')->orderBy(['id' => SORT_DESC])->one();
    }
    public static function getType()
    {
        return [1=>'Для скорости',2=>'Для объема',3=>'Другое'];
    }
    public static function getUnits()
    {
        return  Units::find()->all();
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Имя'),
            'name_en' => Yii::t('app', 'Имя на английском'),
            'name_hy' => Yii::t('app', 'Имя на армянском'),
            'type' => Yii::t('app', 'Тип')
        ];
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
                'tableName' => "{{%units_lang}}",
                'attributes' => [
                    'name'
                ]
            ],
        ];
    }

    /**
     * @return MultilingualQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }
}

