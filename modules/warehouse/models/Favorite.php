<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_favorite".
 *
 * @property int $id
 * @property string|null $link
 * @property int $user_id
 */
class Favorite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_favorite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
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
            'link' => 'Link',
            'user_id' => 'User ID',
            'title' => 'Title',
        ];
    }
}
