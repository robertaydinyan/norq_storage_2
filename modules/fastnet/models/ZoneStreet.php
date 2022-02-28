<?php

namespace app\modules\fastnet\models;

use Yii;

/**
 * This is the model class for table "f_zone_street".
 *
 * @property int $id
 * @property int|null $zone_id
 * @property int|null $street_id
 */
class ZoneStreet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_zone_street';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zone_id', 'street_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'zone_id' => 'Zone ID',
            'street_id' => 'Street ID',
        ];
    }
}
