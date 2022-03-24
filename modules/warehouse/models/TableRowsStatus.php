<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_table_rows_status".
 *
 * @property int $id
 * @property string $page_name
 * @property string $row_name
 * @property string $row_name_normal
 * @property int $status
 * @property int $userID
 * @property int $order
 */
class TableRowsStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_table_rows_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_name', 'row_name'], 'required'],
            [['status', 'userID', 'order'], 'integer'],
            [['page_name', 'row_name', 'row_name_normal'], 'string', 'max' => 255],
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
            'row_name' => 'Row Name',
            'row_name_normal' => 'Row Name Normal',
            'status' => 'Status',
            'userID' => 'userID',
            'order' => 'Order',
        ];
    }
}
