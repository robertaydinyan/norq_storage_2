<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_view_list".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $view_id
 */
class ViewList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_view_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'view_id'], 'integer'],
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
            'view_id' => 'View ID',
        ];
    }
}
