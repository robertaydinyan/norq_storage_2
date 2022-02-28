<?php

namespace app\modules\crm\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "company_type".
 *
 * @property int $id
 * @property string|null $name
 */
class CompanyType extends \yii\db\ActiveRecord
{

    public $name_hy;
    public $name_en;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name' , 'name_en'  , 'name_hy'], 'string', 'max' => 255],
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
                'tableName' => "{{%company_type_lang}}",
                'attributes' => [
                    'name'
                ]
            ],
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

    public static function getLastId()
    {
        return self::find()->select('id')->orderBy(['id' => SORT_DESC])->one();
    }


    public static function getCompanyType()
    {
        return  CompanyType::find()->all();
    }

    /**
     * @return MultilingualQuery|ActiveQuery
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

}
