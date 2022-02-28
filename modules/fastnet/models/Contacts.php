<?php

namespace app\modules\fastnet\models;

use Yii;

/**
 * This is the model class for table "f_contacts".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $lastname
 * @property string|null $surname
 * @property string|null $phone
 * @property string|null $visit_day
 */
class Contacts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visit_day'], 'safe'],
            [['name', 'lastname', 'surname', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Անուն',
            'lastname' => 'Ազգանուն',
            'surname' => 'Հայրանուն',
            'phone' => 'Հեռախոսահամար',
            'visit_day' => 'Այցելության օր
            ',
        ];
    }
}
