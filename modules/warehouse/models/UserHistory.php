<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "user_history".
 *
 * @property int $id
 * @property int $user_id
 * @property string $link
 * @property int $time
 */
class UserHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'link', 'time', 'title'], 'required'],
            [['user_id', 'time'], 'integer'],
            [['link', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'link' => 'Link',
            'time' => 'Time',
        ];
    }
}
