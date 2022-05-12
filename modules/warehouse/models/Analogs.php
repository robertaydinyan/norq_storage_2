<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_analogs".
 *
 * @property int $id
 * @property int $product_id
 * @property int $analog_id
 */
class Analogs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_analogs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['product_id', 'isDeleted'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => Yii::t('app', 'Original'),
            'analog_id' => Yii::t('app', 'Analog'),
            'isDeleted' => 'isDeleted'
        ];
    }
    public function attributeLabelsAll()
    {
        return [
            'id' => 'ID',
            'product_id' => Yii::t('app', 'Original'),
            'analog_id' => Yii::t('app', 'Analog'),
            'isDeleted' => 'isDeleted'
        ];
    }
    public function getNomiclatureName($type){
        if($type){
            $nomiclature_id = $this->product_id;
        } else {
           $nomiclature_id = $this->analog_id; 
        }
        return NomenclatureProduct::findOne(['id'=>$nomiclature_id])->name;
    }
}