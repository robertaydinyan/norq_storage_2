<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "currency_value".
 *
 * @property int $id
 * @property int $currencyID
 * @property int $value
 * @property string $date
 * @property string|null $code_
 */
class CurrencyValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['currencyID', 'value', 'date'], 'required'],
            [['currencyID', 'value'], 'integer'],
            [['date'], 'safe'],
            [['code_'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'currencyID' => 'Currency ID',
            'value' => 'Value',
            'date' => 'Date',
            'code_' => 'Code',
        ];
    }
}
