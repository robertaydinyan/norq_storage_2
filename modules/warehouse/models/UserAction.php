<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "user_actions".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $action_id
 */
class UserAction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_actions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'action_id'], 'integer'],
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
            'action_id' => 'Action ID',
        ];
    }
}
