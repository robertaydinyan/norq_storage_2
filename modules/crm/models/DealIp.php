<?php

namespace app\modules\crm\models;

use Yii;

/**
 * This is the model class for table "deal_ip".
 *
 * @property int $id
 * @property int|null $deal_id
 * @property int|null $ip_id
 */
class DealIp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deal_ip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deal_id', 'ip_id'], 'integer'],
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
            'ip_id' => 'Ip ID',
        ];
    }
}
