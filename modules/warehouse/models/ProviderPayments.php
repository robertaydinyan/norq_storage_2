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
            [[ 'provider_id','price'], 'integer'],['invoice','string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return ['price'=>'Գումար','provider_id'=>'Մատակարար'];
    }

}
