<?php

namespace app\modules\fastnet\models;

use Yii;

/**
 * This is the model class for table "f_zone_community".
 *
 * @property int $id
 * @property int|null $zone_id
 * @property int|null $community_id
 */
class ZoneCommunity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_zone_community';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zone_id', 'community_id'], 'integer'],
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
            'community_id' => 'Community ID',
        ];
    }
}
