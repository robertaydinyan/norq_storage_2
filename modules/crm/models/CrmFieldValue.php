<?php

namespace app\modules\crm\models;

use Yii;

/**
 * This is the model class for table "crm_field_value".
 *
 * @property int $id
 * @property int|null $field_id
 * @property string|null $value
 * @property int|null $column_id
 */
class CrmFieldValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_field_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_id', 'column_id'], 'integer'],
            [['value'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'field_id' => Yii::t('app', 'Field ID'),
            'value' => Yii::t('app', 'Value'),
            'column_id' => Yii::t('app', 'Column ID'),
        ];
    }
}
