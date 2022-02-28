<?php

namespace app\modules\fastnet\models;

use Yii;

/**
 * This is the model class for table "f_deal_connect_mikrotik".
 *
 * @property int $id
 * @property string $deal_id
 * @property string|null $mikrotik_id
 * @property string|null $micro_queue_id
 */
class DealConnectMikrotik extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_deal_connect_mikrotik';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deal_id'], 'required'],
            [['deal_id'], 'string'],
            [['mikrotik_id', 'micro_queue_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'deal_id' => 'Deal ID',
            'mikrotik_id' => 'Mikrotik ID',
        ];
    }
}
