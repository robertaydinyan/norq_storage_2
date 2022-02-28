<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_partners_list".
 *
 * @property int $id
 * @property string $name
 */
class PartnersList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_partners_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
            'name' => 'Անուն',
        ];
    }
}
