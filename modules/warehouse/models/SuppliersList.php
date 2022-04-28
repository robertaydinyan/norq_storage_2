<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_suppliers_list".
 *
 * @property int $id
 * @property string $name
 * @property string $vat
 * @property string $legal_address
 * @property string $business_address
 * @property string $phone
 * @property string $email
 * @property string $comment
 * @property int $contract_type
 * @property int $parent_id
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
            [['name', 'vat', 'legal_address', 'business_address', 'phone', 'email', 'comment'], 'string', 'max' => 255],
            [['contract_type'], 'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Name'),
            'vat' => Yii::t('app', 'Vat'),
            'legal_address' =>  Yii::t('app', 'Legal Address'),
            'business_address' =>  Yii::t('app', 'Business Address'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'comment' => Yii::t('app', 'Comment'),
            'contract_type' => Yii::t('app', 'Contract Type'),
            'parent_id' => 'Parent ID',
        ];
    }
}