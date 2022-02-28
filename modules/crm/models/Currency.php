<?php

namespace app\modules\crm\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property string|null $name
 */
class Currency extends \yii\db\ActiveRecord
{

    public $name_hy;
    public $name_en;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'name_en'  , 'name_hy','symbol'], 'string', 'max' => 255],
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
            'symbol' => 'Символ',
        ];
    }

    public static function getLastId()
    {
        return self::find()->select('id')->orderBy(['id' => SORT_DESC])->one();
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
                'tableName' => "{{%currency_lang}}",
                'attributes' => [
                    'name'
                ]
            ],
        ];
    }

    public static function getCurrency()
    {
        return  Currency::find()->all();
    }

    /**
     * @return MultilingualQuery|ActiveQuery
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }
}
