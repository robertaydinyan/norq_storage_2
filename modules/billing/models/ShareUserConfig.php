<?php

namespace app\modules\billing\models;

use Yii;

/**
 * This is the model class for table "b_share_user_config".
 *
 * @property int $share_id
 * @property int $user_id
 */
class ShareUserConfig extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'b_share_user_config';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['share_id', 'user_id'], 'required'],
            [['share_id', 'user_id'], 'integer'],
            [['share_id', 'user_id'], 'unique', 'targetAttribute' => ['share_id', 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'share_id' => Yii::t('app', 'Share ID'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }
}
