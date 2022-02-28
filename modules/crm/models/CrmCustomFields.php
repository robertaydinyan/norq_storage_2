<?php

namespace app\modules\crm\models;

use Yii;

/**
 * This is the model class for table "crm_custom_fields".
 *
 * @property int $id
 * @property int|null $section_id
 * @property int|null $field_type_id
 * @property string|null $name
 * @property string|null $label
 * @property int|null $status
 * @property int|null $required 0 => not required, 1 => required
 */
class CrmCustomFields extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_custom_fields';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['section_id', 'field_type_id', 'status', 'required'], 'integer'],
            [['name', 'label'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'section_id' => Yii::t('app', 'Section ID'),
            'field_type_id' => Yii::t('app', 'Field Type ID'),
            'name' => Yii::t('app', 'Name'),
            'label' => Yii::t('app', 'Label'),
            'status' => Yii::t('app', 'Status'),
            'required' => Yii::t('app', '0 => not required, 1 => required'),
        ];
    }
    public function getFieldsList() {
        return CrmCustomList::find()->where(['custom_field_id'=> $this->id])->all();
    }
    public function fieldType() {
        return CrmFieldType::find()->where(['id'=> $this->field_type_id])->one();
    }

}
