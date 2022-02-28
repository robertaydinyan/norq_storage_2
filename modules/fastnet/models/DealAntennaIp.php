<?php

namespace app\modules\fastnet\models;

use Yii;

/**
 * This is the model class for table "f_deal_antenna_ip".
 *
 * @property int $id
 * @property string|null $deal_number
 * @property int|null $antenna_ip_id
 */
class DealAntennaIp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_deal_antenna_ip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['antenna_ip_id'], 'integer'],
            [['deal_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deal_number' => 'Deal Number',
            'antenna_ip_id' => 'Antenna Ip ID',
        ];
    }
}
