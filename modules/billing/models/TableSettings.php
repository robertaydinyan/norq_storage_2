<?php

namespace app\modules\billing\models;

use Yii;

/**
 * This is the model class for table "table_settings".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $column_status
 * @property string|null $column_order
 * @property string $page
 * @property string|null $column_search
 * @property int $count_show
 * @property string|null $sort_column
 * @property string|null $sort_type
 * @property int $pined
 */
class TableSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'table_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'page'], 'required'],
            [['user_id', 'count_show', 'pined'], 'integer'],
            [['column_status', 'column_order', 'column_search'], 'string'],
            [['page', 'sort_column'], 'string', 'max' => 255],
            [['sort_type'], 'string', 'max' => 4],
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
            'column_status' => Yii::t('app', 'Column Status'),
            'column_order' => Yii::t('app', 'Column Order'),
            'page' => Yii::t('app', 'Page'),
            'column_search' => Yii::t('app', 'Column Search'),
            'count_show' => Yii::t('app', 'Count Show'),
            'sort_column' => Yii::t('app', 'Sort Column'),
            'sort_type' => Yii::t('app', 'Sort Type'),
            'pined' => Yii::t('app', 'Pined'),
        ];
    }
}
