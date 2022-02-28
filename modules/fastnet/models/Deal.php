<?php

namespace app\modules\fastnet\models;

use app\components\Helper;
use app\components\Microtik;
use app\modules\billing\models\AntennaIp;
use app\modules\billing\models\DealPaymentLog;
use app\modules\billing\models\IpAddresses;
use app\modules\crm\models\Company;
use app\modules\crm\models\Contact;
use app\modules\crm\models\ContactAdress;
use app\modules\crm\models\CrmDealVacation;
use app\modules\fastnet\models\DealAddress;
use app\modules\fastnet\models\query\DealQuery;
use app\modules\fastnet\Traits\DealTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "f_deal".
 *
 * @property int $id
 * @property string|null $deal_number
 * @property int|null $contact_id
 * @property int|null $is_provider
 * @property int|null $user_type
 * @property int|null $connect_id
 * @property int|null $base_station_id
 * @property int|null $crm_contact_id
 * @property int|null $crm_company_id
 * @property float|null $amount
 * @property float|null $penalty
 * @property float|null $discount
 * @property float|null $electricity
 * @property float|null $connect_price
 * @property int|null $free
 * @property int|null $is_wifi
 * @property int|null $connect_type
 * @property int|null $service_type
 * @property int|null $binding_speed
 * @property int|null $down_binding_speed
 * @property string|null $speed_date_start
 * @property string|null $speed_date_end
 * @property int|null $start_deal
 * @property int|null $status
 * @property string|null $wifi_code
 * @property string|null $contract_start
 * @property string|null $contract_end
 * @property string|null $start_day
 * @property string|null $connection_day
 * @property int|null $blacklist
 * @property int|null $is_active
 * @property int|null $disabled_price_deal_c
 * @property bool|null $is_daily
 * @property int|null $month
 * @property string|null $daily_finish_month
 * @property string|null $daily_month_end
 */
class Deal extends \yii\db\ActiveRecord
{

    use DealTrait;

    /** @var string $ip */
    public $ip;

    /** @var bool $ip_status */
    public $ip_status;

    /**
     * @var array
     */
    public $base_station_ip;

    /** @var bool $service_change */
    public $service_change;

    public $disabledDay = 15;
    public $disabledPriceDay = 17;

    /**
     * @var string $antenna_ip
     */
    public $antenna_ip;
    /**
     * @var mixed|null
     */
    private $tariff;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_deal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contact_id', 'is_provider', 'service_type', 'user_type', 'connect_id', 'base_station_id', 'connect_type', 'binding_speed', 'down_binding_speed',
                'is_wifi', 'free','blacklist', 'is_active'], 'integer'],
            [['is_provider', 'free', 'is_wifi'], 'default', 'value' => 0],
            [['start_deal', 'is_active'], 'default', 'value' => 1],
            [['contract_start', 'contract_end', 'start_day', 'connection_day', 'service_change', 'speed_date_start', 'speed_date_end', 'base_station_ip', 'antenna_ip', 'ip',
                'is_daily', 'month', 'daily_finish_month', 'daily_month_end', 'crm_contact_id', 'crm_company_id'], 'safe'],
            [['amount', 'penalty', 'electricity','status', 'discount', 'connect_price', 'disabled_price_deal_c'], 'number'],
            [['deal_number', 'wifi_code'], 'string', 'max' => 255],
        ];
    }

    const USER_TYPE = ['Ֆիզ․ անձ', 'Իրավ․ անձ'];
    const YES_OR_NO = [
        '<i class="fas fa-times text-danger"></i>',
        '<i class="fas fa-check text-success"></i>'
    ];
    const TARIFF_TYPE = ['Փաթեթ', 'Ինտերնետ', 'Հեռուստատեսություն'];
    const CONNECT_TYPE = [1 => 'GPON', 2 => 'ANTENNA', 3 => 'DATA', 4 => 'Կաբելային'];

    /**
     * Deal status
     */
    const CLOSED = 0; // amsva verjum cron ashxateluc pakvac deal ne
    const ACTIVE = 1; // active
    const VACATION = 2; // ardzakurd
    const CONTRACT_TERMINATION = 3; // xzum
    const SUSPENDED = 4; // popoxvac tariff
    const DISABLED = 5; // kasecvac
    const NO_INTERNET = 6; // anjatman or

    /**
     * Deal active or not
     */
    const IS_ACTIVE = 1;
    const INACTIVE = 0;

    /**
     * Deal is daily or not
     */
    const IS_DAILY = 1;
    const NOT_DAILY = 0;

    const BLACKLIST_BLACK = 1;
    const BLACKLIST_WHITE = 0;

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deal_number' => 'Պայմանագրի համար',
            'contact_id' => 'Կոնտակտյին տվյալ',
            'is_provider' => 'Պրովայդեր',
            'service_type' => 'Տիպ',
            'user_type' => 'Ֆիզիկական անձ / Կազմակերպություն',
            'connect_id' => 'Ծառայություն / Փաթեթ',
            'connect_price' => 'Միացման գումար',
            'crm_contact_id' => 'Ֆիզիկական անձ',
            'crm_company_id' => 'Կազմակերպություն',
            'status' => 'Կարգավիճակ',
            'base_station_id' => 'Բազային կայան',
            'base_station_ip' => 'IP հասցե',
            'contract_start' => 'Պայմանագրի սկիզբ',
            'contract_end' => 'Պայմանագրի ավարտ',
            'start_day' => 'Միացման օր',
            'connection_day' => 'Միացման օր',
            'amount' => 'Գին',
            'penalty' => 'Տուգանք',
            'connect_type' => 'Միացման տեսակ',
            'binding_speed' => 'Արագություն (Upload)',
            'down_binding_speed' => 'Արագություն (Download)',
            'speed_date_start' => 'Արագության սկիզբ',
            'speed_date_end' => 'Արագության ավարտ',
            'is_wifi' => 'Wi-Fi',
            'wifi_code' => 'Wi-Fi սերիական համար',
            'electricity' => 'Հոսանքի վճար',
            'free' => 'Անվճար',
            'discount' => 'Զեղչ',
            'ip' => 'IP',
            'ip_status' => 'Անվճար',
            'blacklist' => 'Հաշվապահություն',
            'antenna_ip' => 'IP հասցե',
            'is_daily' => 'Ամսական',
            'month' => 'Ամիս',
            'daily_finish_month' => 'Գործարքի ավարտ (ամս․)',
            'disabled_price_deal_c' => 'Անջատման նվազագույն գումարի չափ',
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

    /**
     * @return DealQuery|\yii\db\ActiveQuery
     */
    public static function find() {
        return new DealQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgreement() {
        return $this->hasOne(DealAgreement::className(), ['deal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMikrotik() {
        return $this->hasOne(DealConnectMikrotik::className(), ['deal_id' => 'deal_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentLog() {
        return $this->hasMany(DealPaymentLog::className(), ['deal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastPaymentLog() {
        return $this->hasOne(DealPaymentLog::className(), ['deal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact(){
        return $this->hasOne(Contacts::className(), ['id' => 'contact_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTariff(){
        return $this->hasOne(Tariff::className(), ['id' => 'connect_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutOfVacation() {
        return $this->hasOne(CrmDealVacation::className(), ['deal_number' => 'deal_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacation() {
        return $this->hasOne(CrmDealVacation::className(), ['deal_number' => 'deal_number'])
            ->onCondition(['status' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses(){
        return $this->hasMany(DealAddress::className(), ['deal_number' => 'deal_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getIpAddress() {
        return $this->hasMany(IpAddresses::className(), ['id' => 'ip_id'])
            ->viaTable(BaseStationsIp::tableName(), ['deal_number' => 'deal_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getAntennaIpAddress() {
        return $this->hasMany(AntennaIp::className(), ['id' => 'antenna_ip_id'])
            ->viaTable(DealAntennaIp::tableName(), ['deal_number' => 'deal_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getContactAddress() {
        return $this->hasMany(ContactAdress::className(), ['id' => 'contact_address_id'])
            ->viaTable(\app\modules\fastnet\models\DealAddress::tableName(), ['deal_number' => 'deal_number']);
    }

    public function getIps() {
        return $this->hasMany(BaseStationsIp::className(), ['deal_number' => 'deal_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealIp() {
        return $this->hasMany(DealIp::className(), ['deal_number' => 'deal_number'])->onCondition(['status' => 0]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealIps() {
        return $this->hasMany(DealIp::className(), ['deal_number' => 'deal_number']);
    }

    /**
     * @return array
     */
    public function selectedIps()
    {
        $IPIds = [];
        foreach ($this->ips as $ip) {
            $IPIds[] = $ip->ip_id;
        }

        return $IPIds;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrmContact(){
        return  $this->hasOne(Contact::className(), ['id' => 'crm_contact_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrmCompany(){
        return  $this->hasOne(Company::className(), ['id' => 'crm_company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale(){
        return $this->hasOne(DealSale::className(), ['deal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStation(){
        return  $this->hasOne(BaseStation::className(), ['id' => 'base_station_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalance() {
        return $this->hasOne(DealBallance::className(), ['deal_id' => 'id']);
    }

    /**
     * @param $id
     * @return string|null
     */
    public static function getFilteredContactFullName($id) {
        $contact = Contact::findOne($id);
        return !empty($contact) ? $contact->name . ' ' . $contact->surname : null;
    }

    /**
     * @param $id
     * @return string|null
     */
    public static function getFilteredCompanyName($id) {
        $company = Company::findOne($id);
        return !empty($company) ? $company->name : null;
    }

    /**
     * @param $id
     * @return string|null
     */
    public static function getFilteredTariff($id) {
        $tariff = Tariff::findOne($id);
        return !empty($tariff) ? $tariff->name : null;
    }

    /**
     * @return array
     */
    public function getAllContact(){
        return  ArrayHelper::map(Contacts::find()->all(), 'id', function ($model){
                return $model['name'].' '.$model['lastname'].' / '.$model['phone'];
                                                    });
    }

    /**
     * @return array
     */
    public function getAllCrmContact(){
        return ArrayHelper::map(Contact::find()->all(), 'id', function ($model) {
            $phone = !empty($model->contactPhone) ? ' | ' . $model->contactPhone[0]->phone : '';
            return $model->name.' '.$model->surname . $phone;
        });

    }

    /**
     * @return array
     */
    public function getAllCrmCompany(){
        return  ArrayHelper::map(Company::find()->all(), 'id', function ($model) {
            $phone = !empty($model->companyPhone) ? ' | ' . $model->companyPhone[0]->phone : '';
            return $model->name . $phone;
        });

    }

    /**
     * @return array
     */
    public function getAllTariff(){
        return ArrayHelper::map(Tariff::find()->select(['id', 'name', 'inet_price'])->all(), 'id', function ($model){
            return $model['name'].' - '.Helper::removeUselessZeroDigits($model['inet_price']);
        });
    }

    public static function getAllTariffsByType($type){
        $tariffs = Tariff::find()->select(['id', 'name', 'inet_price', 'tv_id', 'old_tariff']);
        if ($type == 0) {
            $tariffs = $tariffs->where(['not', ['tv_id' => null]])->andWhere(['not', ['inet_speed' => null]]);
        } elseif ($type == 1) {
            $tariffs = $tariffs->where(['tv_id' => null]);
        } else {
            $tariffs = $tariffs->where(['inet_speed' => null]);
        }
        $list = $tariffs->andWhere(['status' => 1])->all();

        $new_list = [];
        if(!empty($list)) {
            foreach ($list as $el => $val) {
                $old = $val->old_tariff ? ' (ՀԻՆ)' : '';
                $new_list[$el]['id'] = $val->id;

                $price = $val->tv_id ? $val->inet_price + $val->tv->price: $val->inet_price;
                $new_list[$el]['text'] = $val->name.$old.' - '.$price;
            }
        }

        return $new_list;
    }

    /**
     * @param $deal_id
     * @return float|int
     */
    public function getDealIpPriceByCount($deal_id) {
        return DealIp::find()->where(['deal_number' => $deal_id])->andWhere(['status' => 0])->count() * 1000;
    }


}
