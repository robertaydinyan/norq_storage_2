<?php

namespace app\modules\crm\models;

use app\components\FileUpload;
use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "company_document".
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $image
 * @property int|null $type
 */
class CompanyDocument extends \yii\db\ActiveRecord
{

    public $companyDocument;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_document';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'type'], 'integer'],
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'image' => Yii::t('app', 'Image'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @param $company_id
     * @return bool
     */
    public function upload($company_id)
    {
        if ($this->validate()) {

            if ($this->companyDocument) {
                foreach ($this->companyDocument as $file) {
                    static::saveFiles($file, $company_id);
                }
            }
            return true;

        } else {
            return false;
        }
    }

    /**
     * @param $file
     * @param $company_id
     * @throws \yii\base\Exception
     */
    public static function saveFiles($file, $company_id) {
        $fileUpload = new FileUpload();

        $fileName = $fileUpload->hashName($file->baseName) . '.' . $file->extension;
        $model = new CompanyDocument();
        $model->company_id = $company_id;
        $model->type = 0;
        $model->image = $fileName;

        if ($model->save()) {
            if (!file_exists('company_document')) {
                FileHelper::createDirectory('company_document', 777, true);
            }

            $file->saveAs('company_document/' . $fileName);
        }
    }
}
