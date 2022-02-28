<?php

namespace app\modules\billing\models;

use app\modules\crm\models\Cashier;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "deal_payment_log_history".
 *
 * @property int|null $deal_payment_log_id
 * @property int|null $previous_cashier_id
 * @property int|null $current_cashier_id
 * @property string|null $create_at
 */
class DealPaymentLogHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deal_payment_log_history';
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
                    self::EVENT_BEFORE_INSERT => ['create_at']
                ],
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deal_payment_log_id', 'previous_cashier_id', 'current_cashier_id'], 'integer'],
            [['create_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'deal_payment_log_id' => 'Deal Payment Log ID',
            'previous_cashier_id' => 'Previous Cashier ID',
            'current_cashier_id' => 'Current Cashier ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentLog() {
        return $this->hasOne(DealPaymentLog::className(), ['id' => 'deal_payment_log_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreviousCashier() {
        return $this->hasOne(Cashier::className(), ['id' => 'previous_cashier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrentCashier() {
        return $this->hasOne(Cashier::className(), ['id' => 'current_cashier_id']);
    }
}
