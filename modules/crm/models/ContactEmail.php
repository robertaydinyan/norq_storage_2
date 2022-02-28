<?php

namespace app\modules\crm\models;

use Yii;

/**
 * This is the model class for table "contact_email".
 *
 * @property int|null $contact_id
 * @property int|null $company_id
 * @property string|null $name
 * @property int|null $email_type_id
 */
class ContactEmail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_email';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contact_id', 'company_id', 'email_type_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'contact_id' => Yii::t('app', 'Contact ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'name' => Yii::t('app', 'Name'),
            'email_type_id' => Yii::t('app', 'Email Type ID'),
        ];
    }
}
