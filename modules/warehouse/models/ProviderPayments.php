<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_provider_payments".
 *
 * @property int $id
 * @property int|null $provider_id
 * @property string|null $invoice
 * @property int|null $price
 */
class ProviderPayments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_provider_payments';
    }

    /**
     * {@inheritdoc}
     */ 
    public function rules()
    {
        return [
            [[ 'provider_id','price', 'currency'], 'integer'],['invoice','string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'price' => Yii::t('app', 'amount'),
            'provider_id' => Yii::t('app', 'Supplier'),
            'currency' => Yii::t('app', 'Currency'),
        ];
    }
    public function attributeLabelsAll()
    {
        return [
            'id' => 'id',
            'provider_id' => 'Supplier',
            'amount' => 'amount',
            'currency' => 'Currency',
        ];
    }

    public function getCurrencySymbol() {
        return $this->hasOne(Currency::class, ['id' => 'currency']);
    }

}
