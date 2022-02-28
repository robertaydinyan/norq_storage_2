<?php

namespace app\modules\crm\models;

use Yii;

/**
 * This is the model class for table "deal_conect".
 *
 * @property int $id
 * @property int|null $deal_id
 * @property string|null $edit_date
 * @property int|null $installer_id
 * @property int|null $eq_type 1 => Локальное оборудование аренда, 2 => расходные материалы, 3 => Локальное оборудование(продажа), 4 => сетевое оборудование
 * @property int|null $product_id
 * @property int|null $count
 * @property string|null $mac_address
 * @property string|null $price
 * @property string|null $unit
 * @property string|null $ip_address
 */
class DealConect extends \yii\db\ActiveRecord
{
    public $price;
    public $unit;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deal_conect';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deal_id', 'installer_id', 'eq_type', 'product_id', 'count'], 'integer'],
            [['edit_date', 'basis', 'unit', 'price'], 'safe'],
            [['mac_address', 'ip_address'], 'string', 'max' => 255],
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
            'edit_date' => Yii::t('app', 'Edit Date'),
            'installer_id' => Yii::t('app', 'Installer ID'),
            'eq_type' => Yii::t('app', 'Eq Type'),
            'product_id' => Yii::t('app', 'Product ID'),
            'count' => Yii::t('app', 'Count'),
            'mac_address' => Yii::t('app', 'Mac Address'),
            'ip_address' => Yii::t('app', 'Ip Address'),
            'basis' => Yii::t('app', 'Basis'),
        ];

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id'])
            ->andOnCondition(['eq_or_sup' => 1]);
    }

    public static function getConnectsByType($id){
       $all_types = DealConect::find()->where(['deal_id' => $id])->all();
       $new_types = [];
       foreach ($all_types as $type => $value){
           $new_types[$value->eq_type][] = $value;
       }
        $new_types['installer'] = !empty($all_types[0]->installer_id) ? $all_types[0]->installer_id : null;
        $new_types['edit_date'] = !empty($all_types[0]->edit_date) ? $all_types[0]->edit_date : null;

        $products = Product::find()->select('id,name,eq_or_sup,base_amount,unit_id')->all();
        foreach ($products as $product => $product_value){
            $new_types['products'][$product_value->eq_or_sup][] = $product_value;
        }
        return $new_types;
    }
}
?>