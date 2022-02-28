<?php

namespace app\modules\fastnet\models;

use Yii;

/**
 * This is the model class for table "f_deal_agreement".
 *
 * @property int $id
 * @property int|null $deal_id
 * @property string|null $file
 */
class DealAgreement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_deal_agreement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deal_id'], 'integer'],
            [['file'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deal_id' => 'Deal ID',
            'file' => 'File',
        ];
    }
}
