<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "table_rows_count".
 *
 * @property int $id
 * @property string $page_name
 * @property string $column_name
 * @property string $direction
 * @property int|null $count
 * @property int|null $userID
 */
class TableRowsCount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'table_rows_count';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_name'], 'required'],
            [['count', 'userID'], 'integer'],
            [['page_name', 'column_name', 'direction'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_name' => 'Page Name',
            'count' => 'Count',
            'userID' => 'User ID',
            'column_name' => 'column_name',
            'direction' => 'direction',
        ];
    }
}