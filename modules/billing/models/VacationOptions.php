<?php

namespace app\modules\billing\models;

use Yii;

/**
 * This is the model class for table "f_vacation_options".
 *
 * @property int $id
 * @property string|null $name
 */
class VacationOptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_vacation_options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
            'name' => 'Անվանում',
        ];
    }
}
