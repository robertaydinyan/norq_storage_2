<?php

namespace app\modules\fastnet\models;

use Yii;

/**
 * This is the model class for table "f_data".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $base_id
 */
class Data extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_data';
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
    public function getBaseName()
    {
        $names_arr = '';
        $names = DataBase::find()->where(['data_id'=>$this->id])->all();
        if(!empty($names)){
            foreach ($names as $name => $vl){
                $names_arr .= $vl->base->name.', ';
            }
            $names_arr = substr($names_arr,0,-2);
        }
        return $names_arr;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Անուն',
        ];
    }
}
