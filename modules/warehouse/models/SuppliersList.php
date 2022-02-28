<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_suppliers_list".
 *
 * @property int $id
 * @property string $name
 */
class SuppliersList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_suppliers_list';
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
            'name' => 'Անվանում',
        ];
    }
}
