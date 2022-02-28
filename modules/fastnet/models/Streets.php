<?php

namespace app\modules\fastnet\models;

use Yii;

/**
 * This is the model class for table "f_streets".
 *
 * @property int $id
 * @property int $city_id
 * @property int $community_id
 * @property string|null $name
 */
class Streets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_streets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id'], 'required'],
            [['city_id', 'community_id'], 'integer'],
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
            'city_id' => 'Շրջան',
            'community_id' => 'Համայնք',
            'name' => 'Անուն',
        ];
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
