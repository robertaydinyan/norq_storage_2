<?php

namespace app\modules\crm\models;

use app\modules\billing\models\DealPaymentLog;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "crm_cash_register_receipt".
 *
 * @property int $id
 * @property int|null $payment_log_id
 * @property int|null $cashier_id
 * @property int|null $created_by
 * @property int|null $accepted_at
 * @property int|null $create_at
 */
class CashRegisterReceipt extends \yii\db\ActiveRecord
{

    public $price;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_cash_register_receipt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_log_id', 'cashier_id', 'created_by'], 'integer'],
            [['accepted_at', 'create_at', 'price'], 'safe'],
        ];
    }

    /**
     * @return array|array[]
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT => ['create_at'],
                ],
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment_log_id' => 'Գործարք',
            'cashier_id' => 'Գանձապահ',
            'created_by' => 'Ստեղծել է',
            'accepted_at' => 'Ընդունման ամս․',
            'create_at' => 'Ստեղծման ամս․',
            'price' => 'Վճ․ գումար',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentLog() {
        return $this->hasOne(DealPaymentLog::className(), ['id' => 'payment_log_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashier() {
        return $this->hasOne(Cashier::className(), ['id' => 'cashier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(Cashier::className(), ['id' => 'created_by']);
    }
}
