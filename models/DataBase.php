<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "f_data_base".
 *
 * @property int $id
 * @property int|null $data_id
 * @property int|null $base_id
 */
class DataBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_data_base';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_id', 'base_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data_id' => 'Data ID',
            'base_id' => 'Base ID',
        ];
    }
}
