<?php

namespace app\modules\billing\models;

use Yii;

/**
 * This is the model class for table "search_settings".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $page
 * @property string|null $column_search
 * @property string|null $name
 */
class SearchSettings extends \yii\db\ActiveRecord
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
            [['user_id'], 'integer'],
            [['column_search'], 'string'],
            [['page', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'page' => Yii::t('app', 'Page'),
            'column_search' => Yii::t('app', 'Column Search'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
