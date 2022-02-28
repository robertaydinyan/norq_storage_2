<?php

namespace app\modules\crm\models;

use Yii;

/**
 * This is the model class for table "f_cashier_operator".
 *
 * @property int $cashier_id
 * @property int $operator_id
 */
class CashierOperator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_cashier_operator';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cashier_id', 'operator_id'], 'required'],
            [['cashier_id', 'operator_id'], 'integer'],
            [['cashier_id', 'operator_id'], 'unique', 'targetAttribute' => ['cashier_id', 'operator_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cashier_id' => 'Cashier ID',
            'operator_id' => 'Operator ID',
        ];
    }
}
