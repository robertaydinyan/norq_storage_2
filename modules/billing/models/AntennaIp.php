<?php

namespace app\modules\billing\models;

use Yii;

/**
 * This is the model class for table "f_antenna_ip".
 *
 * @property int $id
 * @property int $base_station_id
 * @property string|null $ip_address
 */
class AntennaIp extends \yii\db\ActiveRecord
{

    /**
     * @var string $ip_start
     */
    public $ip_start;

    /**
     * @var string $ip_end
     */
    public $ip_end;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_antenna_ip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip_address', 'base_station_id'], 'safe'],
            [['ip_start', 'ip_end'], 'ip'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip_address' => 'Ip հասցե',
            'base_station_id' => 'Բազային կայան'
        ];
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getList() {
        return self::find()->all();
    }

    /**
     * @param $bs_id
     * @param array $update
     * @return array
     */
    public static function all($bs_id, $update = []){
        $ip = self::find()->where(['base_station_id' => $bs_id]);
        if(!empty($update)) {
            $ip->orWhere(['in', 'id', $update]);
        }

        $options = [];

        if (!empty($ip->all())) {
            foreach ($ip->all() as $option) {
                $options[] = ['id' => $option['id'], 'text' => $option['ip_address']];
            }
        }
        return $options;
    }
}
