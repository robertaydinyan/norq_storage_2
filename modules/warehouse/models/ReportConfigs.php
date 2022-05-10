<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_report_configs".
 *
 * @property int $id
 * @property int|null $report_type
 * @property string|null $date_start
 * @property string|null $date_end
 * @property int|null $warehouse_type
 * @property int|null $product_id
 * @property int|null $group_id
 * @property int|null $is_warehouse
 * @property int|null $is_series
 * @property string $report_name
 * @property int|null $supplier_warehouse_id
 * @property int|null $userID
 * @property int|null $nomiclature_id
 */
class ReportConfigs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_report_configs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['report_type', 'warehouse_type', 'product_id', 'group_id', 'is_warehouse', 'is_series', 'supplier_warehouse_id', 'userID', 'nomiclature_id'], 'integer'],
            [['date_start', 'date_end'], 'safe'],
            [['report_name'], 'required'],
            [['report_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'report_type' => 'Report Type',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'warehouse_type' => 'Warehouse Type',
            'product_id' => 'Product ID',
            'group_id' => 'Group ID',
            'is_warehouse' => 'Is Warehouse',
            'is_series' => 'Is Series',
            'report_name' => 'Report Name',
            'supplier_warehouse_id' => 'Supplier Warehouse ID',
            'userID' => 'User ID',
            'nomiclature_id' => 'nomiclature_id',
        ];
    }
}