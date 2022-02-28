<?php

namespace app\modules\fastnet\models;

use app\modules\billing\models\DisruptionOptions;
use Yii;

/**
 * This is the model class for table "f_deal_disruption".
 *
 * @property int $id
 * @property int|null $deal_id
 * @property int|null $reason_id
 * @property string|null $reason_text
 * @property string|null $create_at
 * @property string|null $update_at
 */
class DealDisruption extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_deal_disruption';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deal_id', 'reason_id'], 'integer'],
            [['reason_text'], 'string'],
            [['create_at', 'update_at'], 'safe'],
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
            'reason_id' => 'Reason ID',
            'reason_text' => 'Reason Text',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    public function getReasonName() {
        return  DisruptionOptions::findOne(['id' => $this->reason_id])->name;
    }
}
