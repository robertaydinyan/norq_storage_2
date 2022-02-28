<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "s_balance".
 *
 * @property int $id
 * @property int|null $date_create
 * @property int|null $warehouse_id
 * @property int|null $cost
 * @property string|null $deal_number
 * @property int|null $status
 */
class Balance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_balance';
    }

    /**
     * {@inheritdoc}
     */ 
    public function rules()
    {
        return [
            [[ 'warehouse_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [];
    }

    public static function getBalance($deal_number){
        $cost = Yii::$app->db->createCommand("SELECT SUM(cost) as sum_ FROM s_balance WHERE deal_number = '$deal_number' AND status = 0")->queryOne()['sum_'];
        $payed = Yii::$app->db->createCommand("SELECT SUM(cost) as sum_ FROM s_balance WHERE deal_number = '$deal_number' AND status = 1")->queryOne()['sum_'];
        return ['debt'=>floatval($cost-$payed), 'payed'=> floatval($payed), 'cost'=> floatval($cost)];
    }
    public static function setBalance($deal_number, $amount){
         
         $newBalance = Balance::find()->where(['deal_number'=>$deal_number])->one();
         $newBalance->id = null;
         $newBalance->isNewRecord = true;
         $newBalance->date_create = date('Y-m-d');
         $newBalance->deal_number = $deal_number;
         $newBalance->cost = $amount;
         $newBalance->status = 1;
         $res = $newBalance->save(false);
        
        $cost = Yii::$app->db->createCommand("SELECT SUM(cost) as sum_ FROM s_balance WHERE deal_number = '$deal_number' AND status = 0")->queryOne()['sum_'];
        $payed = Yii::$app->db->createCommand("SELECT SUM(cost) as sum_ FROM s_balance WHERE deal_number = '$deal_number' AND status = 1")->queryOne()['sum_'];
        return ['result'=>$res,'debt'=>floatval($cost-$payed), 'payed'=> floatval($payed), 'cost'=> floatval($cost)];
    }
}
