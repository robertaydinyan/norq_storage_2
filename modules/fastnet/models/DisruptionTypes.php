<?php

namespace app\modules\fastnet\models;

use Yii;

/**
 * This is the model class for table "f_disruption_types".
 *
 * @property int $id
 * @property string|null $name
 */
class DisruptionTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_disruption_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
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
        ];
    }
}
