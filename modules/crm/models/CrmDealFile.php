<?php

namespace app\modules\crm\models;

use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "crm_deal_file".
 *
 * @property int $id
 * @property int|null $deal_id
 * @property string|null $file
 */
class CrmDealFile extends \yii\db\ActiveRecord
{
    public $file_path;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_deal_file';
    }
    public function uploadDocument()
    {
        if ($this->validate()) {

            $path = Yii::getAlias('@web/uploads/deals');

            if (!file_exists($path)) {
                FileHelper::createDirectory($path, 0777, true);
            }

            $this->file_path->saveAs($path . $this->file_path->baseName . '.' . $this->file_path->extension);

            return true;
        } else {
            return false;
        }
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
            'id' => Yii::t('app', 'ID'),
            'deal_id' => Yii::t('app', 'Deal ID'),
            'file' => Yii::t('app', 'File'),
        ];
    }
}
