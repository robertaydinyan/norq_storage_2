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
class CrmCustomList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_custom_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'string', 'max' => 255],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'custom_field_id' => Yii::t('app', 'Custom Field Type ID'),
            'value' => Yii::t('app', 'Name'),
        ];
    }

}
