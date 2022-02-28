<?php

namespace app\modules\billing\models;

use app\modules\crm\models\Contact;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;

/**
 * This is the model class for table "b_share".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $service_id
 * @property int|null $is_personal
 * @property string|null $comment
 */
class Share extends \yii\db\ActiveRecord
{
    public $client_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'b_share';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_date', 'end_date', 'client_id'], 'safe'],
            [['service_id', 'is_personal'], 'integer'],
            [['comment'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Название'),
            'start_date' => Yii::t('app', 'Дата начала'),
            'end_date' => Yii::t('app', 'Дата окончания'),
            'service_id' => Yii::t('app', 'Сервис'),
            'is_personal' => Yii::t('app', 'Личное'),
            'comment' => Yii::t('app', 'Комментарий'),
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
                'tableName' => "{{%b_share_lang}}",
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

    /**
     * @param $share_id
     * @return array
     */
    public static function getSelectedContacts($share_id)
    {
        $share = ShareUserConfig::find()->where(['share_id' => $share_id])->all();
        $arr = [];

        foreach ($share as $shares) {
            $arr[] = Contact::find()->where(['id' => $shares->user_id])->one();
        }

        return $arr;
    }

    /**
     * @return array|\yii\db\ActiveRecord|null
     */
    public static function lastId()
    {
        return self::find()->orderBy(['id' => SORT_DESC])->one()['id'];
    }
    public static function getListForSearch()
    {
        $list =  Share::find()->all();
        $new_list = [];
        if(!empty($list)) {
            foreach ($list as $el => $val) {
                $new_list[$el]['value'] = $val->id;
                $new_list[$el]['name'] = $val->name;
            }
        }
        return $new_list;
    }
    public  function getTariffs()
    {
        $res = ShareTariffConfig::find()->where(['share_id' => $this->id])->all();
        return $res;
    }
}
