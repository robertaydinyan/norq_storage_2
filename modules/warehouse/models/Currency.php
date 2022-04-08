<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property string $symbol
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['symbol'], 'required'],
            [['symbol'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'symbol' => Yii::t('app', 'Symbol'),
        ];
    }

    public static function getCurrencyByID($id) {
        return Currency::find()->where(['id' => $id])->one()['symbol'];
    }
}
