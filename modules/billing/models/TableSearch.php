<?php

namespace app\modules\billing\models;

use Yii;

/**
 * This is the model class for table "w_search_settings".
 *
 * @property int $id
 * @property int $rack_id
 * @property int|null $name
 */
class TableSearch extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'search_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [];
    }



}
