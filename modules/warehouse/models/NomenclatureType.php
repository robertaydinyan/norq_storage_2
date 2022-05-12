<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_nomenclature_type".
 *
 * @property int $id
 * @property string $name
 * @property int $isDeleted
 */
class NomenclatureType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_nomenclature_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['isDeleted'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
    public function attributeLabelsAll()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
