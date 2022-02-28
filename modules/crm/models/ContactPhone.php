<?php

namespace app\modules\crm\models;

use Yii;

/**
 * This is the model class for table "crm_contact_phone".
 *
 * @property int|null $contact_id
 * @property int|null $company_id
 * @property string|null $phone
 * @property int|null $phone_type_id
 */
class ContactPhone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_contact_phone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contact_id',  'phone_type_id','company_id'], 'integer'],
            [['phone'], 'string', 'max' => 255],
            [['phone'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'contact_id' => Yii::t('app', 'Contact ID'),
            'phone' => Yii::t('app', 'Phone'),
            'phone_type_id' => Yii::t('app', 'Phone Type ID'),
        ];
    }
}
