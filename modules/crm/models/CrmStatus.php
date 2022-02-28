<?php

namespace app\modules\crm\models;

use Yii;

/**
 * This is the model class for table "crm_status".
 *
 * @property int $id
 * @property int|null $field_id
 * @property int|null $value
 * @property int|null $column_id
 */
class CrmStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['menu_id' , 'ordering' , 'type_id' ], 'integer'],
            [['color','name' ], 'safe'],
        ];
    }
    public static function getLastId()
    {
        return self::find()->select('id')->orderBy(['id' => SORT_DESC])->one();
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Имя'),
            'menu_id' => Yii::t('app', 'Меню ID'),
        ];
    }

    public static function getCrmStatus()
    {
        return  CrmStatus::find()->all();
    }
    public static function getListForSearch()
    {
       $list =  CrmStatus::find()->where(['menu_id'=>5])->all();
       $new_list = [];
       if(!empty($list)) {
           foreach ($list as $el => $val) {
               $new_list[$el]['value'] = $val->id;
               $new_list[$el]['name'] = $val->name;
           }
       }
       return $new_list;
    }

    public static function checkOrderID($type_id) {
        if (!is_null($type_id)) {
            return self::find()->where(['type_id' => $type_id])->max('ordering');
        } else {
            return false;
        }

    }
    public static function findAllStatuses($type_id) {
        $new_statuses = [];
        $all_statuses = CrmStatus::find()->where(['type_id'=>$type_id])->all();
        foreach ($all_statuses as $status => $value){
            $new_statuses[$value->status_type][] = $value;
        }
        return $new_statuses;
    }

}
