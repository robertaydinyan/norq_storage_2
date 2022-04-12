<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cron".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $start
 * @property string|null $end
 */
class Cron extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cron';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start', 'end'], 'safe'],
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
            'name' => 'Name',
            'start' => 'Start',
            'end' => 'End',
        ];
    }



    public  function save_date () {
        $this->name = 'test';
        $this->start = date('y-m-d h:m');
        $this->save();
        Cron::find()->all();
    }
}
