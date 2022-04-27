<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "barcode".
 *
 * @property int $id
 * @property string|null $code
 * @property int|null $numenclature_id
 */
class Barcode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'barcode';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numenclature_id'], 'integer'],
            [['code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => Yii::t('app', 'Code'),
            'numenclature_id' => 'Numenclature ID',
        ];
    }
}
