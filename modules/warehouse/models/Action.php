<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "actions".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $controller_name
 * @property string|null $action_name
 */
class Action extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'controller_name', 'action_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'controller_name' => 'Controller Name',
            'action_name' => 'Action Name',
        ];
    }

    public function hasAccess($userID) {
        return UserAction::find()->where(['user_id' => $userID, 'action_id' => $this->id])->count() != 0;
    }

    public function getByControllerName() {
        return $this->hasMany(Action::class, ['controller_name' => 'controller_name'])->all();
    }

}
