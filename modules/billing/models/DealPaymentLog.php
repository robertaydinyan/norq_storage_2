<?php

namespace app\modules\billing\models;

use app\components\Helper;
use app\models\User;
use app\modules\crm\models\Cashier;
use app\modules\fastnet\models\Deal;
use app\modules\fastnet\models\DealBallance;
use PDO;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "deal_payment_log".
 *
 * @property int $id
 * @property int|null $deal_id
 * @property float|null $price
 * @property string $create_at
 * @property int $operator_id
 * @property int $payment_type
 * @property int $status
 * @property string $receipt;
 * @property string $pay_date;
 * @property string $update_at;
 * @property string $hdm;
 * @property string $comment;
 * @property string $payer;
 */
class DealPaymentLog extends \yii\db\ActiveRecord
{

    const Cashier = 1;
    const EasyPay = 2;
    const TelCell = 3;
    const HayPost = 4;

    const NOT_HDM = 0;
    const HDM = 1;

    public $blacklisted;
    public $is_daily;

    public $address;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deal_payment_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deal_id','operator_id','status','payment_type', 'hdm', 'payer'], 'integer'],
            [['price'], 'number'],
            [['create_at', 'update_at', 'receipt', 'pay_time', 'comment', 'blacklisted', 'address', 'is_daily'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'deal_id' => Yii::t('app', 'Գործարք'),
            'price' => Yii::t('app', 'Գումար'),
            'create_at' => Yii::t('app', 'Վճարման օր'),
            'update_at' => Yii::t('app', 'Վճարի ընդունման օր'),
            'operator_id' => Yii::t('app', 'Վճարող օպ․'),
            'status' => Yii::t('app', 'Կարգավիճակ'),
            'payment_type' => Yii::t('app', 'Վճարման տեսակ'),
            'receipt' => Yii::t('app', 'Անդորագրի համար'),
            'pay_date' => Yii::t('app', 'Վճարման անսաթիվ'),
            'hdm' => Yii::t('app', 'ՀԴՄ'),
            'comment' => Yii::t('app', 'Մեկնաբանություն'),
            'payer' => Yii::t('app', 'Վճարում ընդ․ օպ․'),
            'blacklisted' => Yii::t('app', 'Հաշվ.'),
            'is_daily' => Yii::t('app', 'Ամսական'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeal() {
        return $this->hasOne(Deal::className(), ['id' => 'deal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashier() {
        return $this->hasOne(Cashier::className(), ['id' => 'operator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashierPayer() {
        return $this->hasOne(Cashier::className(), ['id' => 'payer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistory() {
        return $this->hasMany(DealPaymentLogHistory::className(), ['deal_payment_log_id' => 'id']);
    }

    /**
     * @return string[]
     */
    public static function setPayType() {
        return [
            'easypay' => self::EasyPay,
            'telcell' => self::TelCell,
            'haypost' => self::HayPost,
        ];
    }

    /**
     * @return string[]
     */
    public function getPaymentType() {
        return [
            self::Cashier => 'Կասա',
            self::EasyPay => 'EasyPay',
            self::TelCell => 'TelCell',
            self::HayPost => 'HayPost',
        ];
    }

    /**
     * @return string
     */
    public function getOperator() {
        return User::findOne(['id'=>$this->operator_id])->username;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealFast() {
        return $this->hasOne(\app\modules\fastnet\models\Deal::className(), ['id' => 'deal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalance() {
        return $this->hasOne(DealBallance::className(), ['deal_id' => 'deal_id']);
    }

    /**
     * @param $ids
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function groupedDealPaymentLog($ids, $last_id) {
        $paymentLog = DealPaymentLog::find()->where(['in', 'deal_id', $ids])->orderBy(['deal_id'=> SORT_DESC])->all();
        $total = 0;
        $arrLog = [];

        foreach ($paymentLog as $key => $log){
            if($last_id == $log->deal_id){
                $total += $log->price;
            }
            $arrPaidLog = [];
            $arrPaidLog['price'] = $log->price;
            $arrPaidLog['create_at'] = $log->create_at;
            $arrLog['history'][Helper::dateNotTime($log->dealFast->contract_start).'/'.Helper::getlastDayMonthForPaymentLog($log->dealFast->contract_start)][] = $arrPaidLog;

        }
        $arrLog['total'] = $total;
        return $arrLog;
    }
    public static function groupedPaymentLogById($id) {

        $paymentLog = DealPaymentLog::find()->where(['id' => $id])->one();
        $total = 0;
        $arrLog = [];
        $arrPaidLog = [];
        $arrPaidLog['price'] = $paymentLog->price;
        $arrPaidLog['create_at'] = $paymentLog->create_at;
        $arrLog['history'][Helper::dateNotTime($paymentLog->deal->update_at).'/'.Helper::getlastDayMonthForPaymentLog($paymentLog->deal->update_at)][] = $arrPaidLog;
        $arrLog['total'] = $total;

        return $arrLog;
    }
    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function dealByContactOrCompany($id) {
        if (!is_null($id)) {
            return Deal::find()->where(['contact_id' => $id])->orWhere(['company_id' => $id])->all();
        }
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function logPayments($id) {
        return DealPaymentLog::find()->where(['deal_id' => $id])->orderBy(['create_at' => SORT_DESC])->all();
    }

    public static function logPaymentsHistory($deal_number, $start = null, $end = null) {
        if(!$start && !$end){
            $start = date('Y-m').'-01';
            $end =   date('Y-m-d');
        }

       $end = date("Y-m-d", strtotime("+1 month", strtotime($end)));


        $sql_pay_log = Yii::$app->db->createCommand("SELECT DATE(p_log.create_at) as d, p_log.price as pay, 1  as is_pay  from deal_payment_log as p_log
                                                            LEFT join f_deal as de ON p_log.deal_id = de.id
                                                            WHERE de.deal_number = '$deal_number' AND p_log.create_at BETWEEN '$start' AND '$end' ")->queryAll();

        $sql_balance = Yii::$app->db->createCommand("SELECT DATE(bal.date) as d, bal.balance as pay, 0 as is_pay  from f_deal_ballance as bal
                                                            LEFT join f_deal as de ON bal.deal_id = de.id
                                                            WHERE de.deal_number = '$deal_number' AND bal.date BETWEEN '$start' AND '$end'")->queryAll();

        $arr = array_merge($sql_balance, $sql_pay_log);
        usort($arr, function( $a, $b ) {
            return strtotime($a["d"]) - strtotime($b["d"]);
        });

        $history = [];
        $deletingArr = [];

        foreach ($arr as $key =>  $a){
            $history[$key]['changeTariff'] = false;
            if($key == 0){
                $history[$key]['date'] = $a['d'];
                $history[$key]['pay'] = 0;
                $history[$key]['balance'] = $a['pay'];
            }else{
                $history[$key]['date'] = $a['d'];
                if($a['is_pay'] == 0){

                    if($arr[$key - 1]['is_pay'] == 0){

                        $history[$key]['pay'] = $arr[$key + 1]['pay'];
                        $history[$key]['balance'] = $a['pay'];
                        $history[$key]['changeTariff'] = true;

                     $deletingArr[] = $key + 1;


                    }else{
                        $history[$key]['pay'] = 0;
                        $history[$key]['balance'] = $a['pay'];
                    }
                }else{
                    if(!in_array($key, $deletingArr)){

                        $history[$key]['pay'] = $a['pay'];
                        if(isset($arr[$key - 2]) && isset($arr[$key - 3]) && $arr[$key - 2]['is_pay'] == 0 && $arr[$key - 3 ]['is_pay'] == 0){

                            $history[$key]['balance'] = $arr[$key - 2]['pay'] - $a['pay'];
                        }else{

                            $history[$key]['balance'] = $history[$key-1]['balance'] - $a['pay'];
                        }
                    }else{
                        unset($history[$key]);
                    }

                }

            }
        }

        return $history;
    }

    /**
     * @param $id
     * @return bool|int|mixed|string|null
     */
    public static function logPaymentsSumm($id) {
        $query = DealPaymentLog::find()->where(['deal_id' => $id])->sum('price');
        return $query;
    }

//    public static function currentMonthTotal($deal_id){
//        $start = date('Y-m').'-01';
//        $end = date("Y-m-t", strtotime(date('Y-m-d')));
//        $sql = Yii::$app->db->createCommand("SELECT SUM(price) as total FROM deal_payment_log WHERE create_at BETWEEN '$start' AND '$end' AND deal_id = $deal_id")->queryOne();
//        return $sql;
//    }

    /**
     * @param $deal_id
     * @return int|mixed
     * @throws \yii\db\Exception
     */
    public static function currentMonthTotal($deal_id){

        $total = Yii::$app->db->createCommand("SELECT SUM(price) as total FROM deal_payment_log WHERE  deal_id = $deal_id")->queryOne()['total'];
        return $total ?? 0;

    }




}
