<?php

namespace app\modules\billing\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "f_community".
 *
 * @property int $id
 * @property int|null $city_id
 * @property string|null $name
 */
class Community extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_community';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id'], 'integer'],
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
            'city_id' => 'Քաղաք',
            'name' => 'Անուն',
        ];
    }

    public static function getAllCommunities()
    {
        return ArrayHelper::map(Community::find()->all(), 'id', 'name');
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
    public static function getByCityId($id) {
        return self::find()->where(['city_id' => $id])->all();
    }
}
