<?php

namespace app\modules\crm\models;

use app\components\FileUpload;
use app\components\Helper;
use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "crm_contact_passport".
 *
 * @property int $id
 * @property int|null $contact_id
 * @property string|null $image
 * @property string|null $contactPassport
 * @property int|null $type
 */
class ContactPassport extends \yii\db\ActiveRecord
{
    public $contactPassport;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_contact_passport';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contact_id', 'type'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['contactPassport'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 5],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'contact_id' => Yii::t('app', 'Image'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @param $contact_id
     * @return bool
     */
    public function upload($contact_id)
    {
        if ($this->validate()) {

            if ($this->contactPassport) {
                foreach ($this->contactPassport as $file) {
                    static::saveFiles($file, $contact_id);
                }
            }
            return true;

        } else {
            return false;
        }
    }

    /**
     * @param $file
     * @param $contact_id
     * @param $type
     */
    public static function saveFiles($file, $contact_id) {
        $fileUpload = new FileUpload();

        $fileName = $fileUpload->hashName($file->baseName) . '.' . $file->extension;
        $model = new ContactPassport();
        $model->contact_id = $contact_id;
        $model->type = 0;
        $model->image = $fileName;

        if ($model->save()) {
            if (!file_exists('contact_passport')) {
                FileHelper::createDirectory('contact_passport', 777, true);
            }

            $file->saveAs('contact_passport/' . $fileName);
        }
    }
}
