<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "actions".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $depID
 */
class ActionDep extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actions_dep';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_name', 'controller_name'], 'string', 'max' => 255],
            [['depID'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_name' => 'Model Name',
            'controller_name' => 'Controller Name',
            'depID' => 'Dep ID',
        ];
    }

    public function hasAccess($userID) {
        var_dump($this);die();
        return UserAction::find()->where(['user_id' => $userID, 'action_id' => $this->depID])->count() != 0;
    }

}
