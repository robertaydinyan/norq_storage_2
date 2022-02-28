<?php

namespace app\modules\crm\models;

use app\components\Helper;
use app\modules\billing\models\IpAddresses;
use app\modules\billing\models\query\ContactQuery;
use app\modules\billing\models\Services;
use app\modules\billing\models\Share;
use app\modules\billing\models\Tariff;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use app\modules\billing\models\DealPaymentLog;
use app\modules\crm\models\query\DealQuery;

/**
 * This is the model class for table "crm_deal".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $create_at
 * @property string|null $update_at
 * @property int|null $status_id
 * @property int|null $ordering
 * @property int|null $amount
 * @property int|null $start_deal
 * @property int|null $currency_id
 * @property int|null $address_id
 * @property int|null $contact_id
 * @property int|null $share_id
 * @property int|null $work_price
 * @property int|null $payment
 * @property int|null $company_id
 * @property int|null $deal_type_id
 * @property int|null $responsible_id
 * @property string|null $date_finish
 * @property int|null $service_id
 * @property int|null $tariff_id
 */
class Deal extends \yii\db\ActiveRecord
{
    public $payment;

    const DealPaymentStatus = [
        0 => 'Счет выставлен',
        1 => 'Проведено',
        2 => 'Текущий долг',
        3 => 'Просроченно',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_deal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','create_at', 'update_at', 'status_id','address_id', 'ordering', 'amount', 'currency_id', 'contact_id', 'company_id', 'deal_type_id', 'responsible_id', 'date_finish', 'service_id', 'tariff_id', 'start_deal','share_id','work_price'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Сделка'),
            'status_id' => Yii::t('app', 'Статус'),
            'create_at' => Yii::t('app', 'Созданно'),
            'update_at' => Yii::t('app', 'Обнавленно'),
            'ordering' => Yii::t('app', 'Порядок'),
            'amount' => Yii::t('app', 'Сумма'),
            'currency_id' => Yii::t('app', 'Ид. валюты'),
            'contact_id' => Yii::t('app', 'Контакт'),
            'company_id' => Yii::t('app', 'Компания'),
            'deal_type_id' => Yii::t('app', 'Тип сделки'),
            'responsible_id' => Yii::t('app', ' Ответственный'),
            'date_finish' => Yii::t('app', 'Дата окончания'),
            'service_id' => Yii::t('app', 'Сервис'),
            'tariff_id' => Yii::t('app', 'Ид. тарифа'),
            'start_deal' => Yii::t('app', 'Начало сделки'),
            'share_id' => Yii::t('app', 'Ид. акции'),
            'work_price' => Yii::t('app', 'Стоимость работы'),
        ];
    }
    /**
     * @return array|array[]
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT => ['create_at', 'update_at'],
                    self::EVENT_BEFORE_UPDATE => 'update_at',
                ],
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    public function kanbanData($type_id = 1){

        $query = Deal::find();
        $columns = CrmStatus::find()->where(['menu_id'=>5,'type_id'=>$type_id])->orderBy(['ordering'=> SORT_ASC ])->asArray()->all();
        $kanban = $query->orderBy(['ordering'=> SORT_ASC ])->asArray()->all();
        return $this->makeKanban($kanban, $columns);
    }
    public function getFiles(){
        return $this->hasMany(CrmDealFile::className(), ['deal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(CrmStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealConnect()
    {
        return $this->hasMany(DealConect::className(), ['deal_id' => 'id']);
    }

    public function makeKanban($kanban, $columns){

        $arrKanban = [];
        if(!empty($columns)) {

            foreach ($columns as $k=> $kbl) {
                $i = 0;

                $arrKanban[$k]['id'] = $kbl['id'];
                $arrKanban[$k]['title'] = $kbl['name'];
                $arrKanban[$k]['alias'] = $kbl['name'];
                $arrKanban[$k]['position'] = $kbl['ordering'];
                $arrKanban[$k]['color'] = $kbl['color'];
                $arrKanban[$k]['order'] = [];
                foreach ($kanban as $ks => $v) {
                    $i++;
                    if($v['status_id'] == $kbl['id'] ) {
                        $arrKanban[$k]['order'][] = ['currency' => 'AMD', 'date' => $v['create_at'], 'amount' => 0, 'id' => $v['id'], 'title' => $v['name'], 'priority' => 1];
                    }
                }
            }
            return $arrKanban;
        }
    }
    public function CalendarData(){
        $query = Deal::find();
        $columns = CrmStatus::find()->where(['menu_id'=>5])->orderBy(['ordering'=> SORT_ASC ])->asArray()->all();
        $calendar = $query->orderBy(['ordering'=> SORT_ASC ])->asArray()->all();
        return $this->makeCalendar($calendar);
    }
    public function getCompanyList(){
        $query = Company::find();
        $res = $query->orderBy(['name'=> SORT_DESC ])->all();
        return ArrayHelper::map($res,'id', 'name');
    }
    public function getContactList(){
        $query = Contact::find();
        $res = $query->orderBy(['name'=> SORT_DESC ])->all();
        return ArrayHelper::map($res,'id', 'name');
    }
    public function getDealTypeList(){
        $query = DealType::find();
        $res = $query->orderBy(['name'=> SORT_DESC ])->all();
        return ArrayHelper::map($res,'id', 'name');
    }
    public function getStatusOrder(){
        $model = CrmStatus::find()->where(['id'=>$this->status_id])->one();
        return $model;
    }
    public function getClient(){
        if(!is_null($this->contact_id)){
            $model = Contact::find()->where(['id'=>$this->contact_id])->one();
        } else if(!is_null($this->company_id)) {
            $model = Company::find()->where(['id'=>$this->company_id])->one();
        } else {
            $model = [];
        }

        return $model;
    }
    public function getProductsByType($type_id){
        return Product::find()->where(['eq_or_sup' => $type_id])->all();
    }
    public function getServiceName(){
        return Services::find()->where(['id' => $this->service_id])->one();
    }
    public function getTariffName(){
        return Tariff::find()->where(['id' => $this->tariff_id])->one();
    }
    public function getShareName(){
        return Share::find()->where(['id' => $this->share_id])->one();
    }
    public function getFields(){
        return CrmFieldType::find()->where(['menu_id' => $this->menu_id])->one();
    }

    public function getAddressName(){
        return ContactAdress::getContactAddressById($this->id);
    }
    public function getIpAddresses(){
        $ips = DealIp::find()->where(['deal_number' => $this->deal_number])->all();
        $return_data = [];
        foreach ($ips as $ip => $ip_value){
            $return_data['values'][] = $ip_value->ip_id;
            $ip_data = IpAddresses::find()->where(['id'=>$ip_value->ip_id])->one();
            $return_data['data'][] = [$ip_value->ip_id=>$ip_data->address];
        }
        return $return_data;
    }

    public static function getDealsByClient($contact, $company){
        $statuses = CrmStatus::find()->select('id')->where(['status_type'=>2])->all();
        $all_statuses = [];
        foreach ($statuses as $status => $val){
            array_push($all_statuses,$val->id);
        }
        $query = Deal::find();
        if(!empty($contact)){
            $query->where(['contact_id'=>$contact->id, 'start_deal'=>1, 'status_id'=>$all_statuses]);
        }
        if(!empty($company)){
            $query->orWhere(['company_id'=>$company->id, 'start_deal'=>1, 'status_id'=>$all_statuses]);
        }
        return $query->orderBy(['id'=>SORT_DESC])->all();
    }



    public function makeCalendar($calendar)
    {
        $arrCalendar = [];
        if (!empty($calendar)) {
            foreach ($calendar as $ks => $v) {
                $arrCalendar[] = ['start' => $v['create_at'], 'icon' => 'circle', 'id' => $v['id'], 'title' => $v['name'], 'status' => $v['status_id']];
            }
        }
        return $arrCalendar;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentLog() {
        return $this->hasMany(DealPaymentLog::className(), ['deal_id' => 'id']);
    }
    public static function getDealByContract($show = false,  $page, $count_show, $sort = 'none', $column , $dataSearch ){
        if($page) {
            $offset = ($page - 1) * $count_show;
        } else {
            $offset = 0;
        }
        if($dataSearch) {
            $filter_all =  explode(',',$dataSearch);
        }
        $where = "concat(YEAR(d_log.create_at), '-', MONTH(d_log.create_at)) = concat(YEAR(deal.update_at), '-', MONTH(deal.update_at))";
        if(!empty($filter_all)){
            $where .= ' AND (';
            for ($i = 0; $i< count($filter_all); $i++){
                $filter_simple =  explode('|',$filter_all[$i]);
                if($filter_simple[0]) {
                    if(($i+2) != count($filter_all)){
                        $where .= 'deal.'.$filter_simple[0] . ' =\'' . $filter_simple[1] . '\' OR ';
                    } else {
                        $where .= 'deal.' . $filter_simple[0] . '= \'' . $filter_simple[1] . '\'';
                    }
                }
            }
            $where.=')';
        }

        if(strtolower($sort) == 'none' || $sort == null){
            $where .= " GROUP BY deal.name ORDER BY deal.id DESC";
        } else {
            if(!in_array($column,['deal_start','debt','paid'])) {
                $where .= " GROUP BY deal.name ORDER BY deal.$column $sort";
            } else {
                $where .= " GROUP BY deal.name ORDER BY $column $sort";
            }

        }

        $sql = "SELECT deal.service_id,deal.share_id,deal.tariff_id,deal.amount,deal.contact_id,deal.company_id,deal.create_at,deal.id, deal.name, work_price, start_deal, deal.amount, SUM(d_log.price) as paid, (SUM(d_log.price) - deal.amount) as debt,  MAX(deal.update_at) as deal_start FROM crm_deal as deal
                LEFT JOIN deal_payment_log as d_log ON d_log.deal_id = deal.id 
                WHERE $where  LIMIT $offset, $count_show  ";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        foreach($data as $key => $deal){

            $data[$key]['id'] = $deal['name'];
            $data[$key]['debt'] = Helper::debt($data[$key]['amount'], $data[$key]['work_price'], $data[$key]['paid'], $deal['start_deal']);
            if(!$show)
                unset($data[$key]['start_deal']);
                unset($data[$key]['work_price']);
                unset($data[$key]['paid']);
                unset($data[$key]['name']);

        }
        $sqlTotal = "SELECT deal.id, SUM(d_log.price) as paid, (SUM(d_log.price) - deal.amount) as debt,  MAX(deal.update_at) as deal_start FROM crm_deal as deal
                LEFT JOIN deal_payment_log as d_log ON d_log.deal_id = deal.id 
                WHERE $where  ";
        $res['data'] = $data;
        $res['total'] = count(Yii::$app->db->createCommand($sqlTotal)->queryAll());
        return $res;
    }

    public function getService() {
        return $this->hasOne(Services::className(), ['id' => 'service_id']);
    }

    public function getTariff() {
        return $this->hasOne(Tariff::className(), ['id' => 'tariff_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    public function getShare() {
        return $this->hasOne(Share::className(), ['id' => 'share_id']);
    }

    public static function find() {
        return new DealQuery(get_called_class());
    }
}
