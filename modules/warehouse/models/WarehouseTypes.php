<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_warehouse_types".
 *
 * @property int $id
 * @property string $name
 */
class WarehouseTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_warehouse_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_hy', 'name_ru', 'name_en'], 'required'],
            [['name_hy', 'name_ru', 'name_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_hy' => Yii::t('app', 'Name(Armenian)'),
            'name_ru' => Yii::t('app', 'Name(Russian)'),
            'name_en' => Yii::t('app', 'Name(English)'),
        ];
    }
    public function getCount() {
        return Warehouse::find()->where(['type'=>$this->id])->count();
    }
}
