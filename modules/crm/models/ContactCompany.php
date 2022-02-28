<?php

namespace app\modules\crm\models;

use Yii;

/**
 * This is the model class for table "contact_company".
 *
 * @property int $contact_id
 * @property int $company_id
 */
class ContactCompany extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contact_id', 'company_id'], 'required'],
            [['contact_id', 'company_id'], 'integer'],
            [['contact_id', 'company_id'], 'unique', 'targetAttribute' => ['contact_id', 'company_id']],
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
        ];
    }
}
