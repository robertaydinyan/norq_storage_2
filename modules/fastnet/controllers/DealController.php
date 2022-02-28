<?php

namespace app\modules\fastnet\controllers;

use app\components\DailyPricing;
use app\components\Helper;
use app\components\Importer\Importer;
use app\components\ManageMikrotik;
use app\components\Microtik;
use app\components\Pricing;
use app\components\TimeHelper;
use app\models\query\BaseQuery;
use app\modules\billing\models\AntennaIp;
use app\modules\billing\models\DealPaymentLog;
use app\modules\billing\models\DisruptionOptions;
use app\modules\billing\models\IpAddresses;
use app\modules\billing\models\VacationOptions;
use app\modules\crm\models\Cashier;
use app\modules\crm\models\Company;
use app\modules\crm\models\Contact;
use app\modules\crm\models\ContactAdress;
use app\modules\crm\models\ContactPassport;
use app\modules\crm\models\ContactPhone;
use app\modules\crm\models\CrmDealVacation;
use app\modules\crm\models\DealAddress;
use app\modules\fastnet\models\DealAddress as FDealAddress;
use app\modules\fastnet\models\BaseStationsIp;
use app\modules\fastnet\models\DealAgreement;
use app\modules\fastnet\models\DealAntennaIp;
use app\modules\fastnet\models\DealBallance;
use app\modules\fastnet\models\DealDisruption;
use app\modules\fastnet\models\DealIp;
use app\modules\fastnet\models\DisabledDay;
use app\modules\fastnet\models\Streets;
use app\modules\fastnet\models\Tariff;
use app\modules\warehouse\models\NomenclatureProduct;
use app\modules\warehouse\models\Product;
use app\modules\warehouse\models\Shipping;
use app\modules\warehouse\models\ShippingProduct;
use app\traits\FindModelTrait;
use Carbon\Carbon;
use DateTime;
use kartik\mpdf\Pdf;
use Yii;
use app\modules\fastnet\models\Deal;
use app\modules\fastnet\models\DealSearch;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Request;
use yii\web\UploadedFile;
use app\modules\warehouse\models\Warehouse;
use function Matrix\diagonal;
use function MongoDB\BSON\fromJSON;
use function DeepCopy\deep_copy;

/**
 * DealController implements the CRUD actions for Deal model.
 */
class DealController extends Controller
{

    use FindModelTrait;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'add-vacation' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Deal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DealSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Deal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
//        $x = Product::find()->select('s_product.id, s_product.count, s_qty_type.type')
//            ->where(['nomenclature_product_id' => 13])
//            ->andWhere(['warehouse_id' => 56])
//            ->joinWith(['nProduct'])
//            ->joinWith(['nProduct.qtyType'])
//            ->asArray()
//            ->all();
        //varDumper($x);die;
        $model = new Deal();
        $crmContact = new Contact();
        $crmCompany = new Company();
        $address = new ContactAdress();
        $contactPassport = new ContactPassport();
        $antennaIp = new AntennaIp();
        $shipping = new Shipping();
        $nProduct = new NomenclatureProduct();
        $shippingProduct = new ShippingProduct();
        $baseWarehouse = new Warehouse();

        $userId = Yii::$app->user->identity->id;

        $warehouse = Warehouse::find()->select(['id'])->where(['user_id' => $userId])->asArray()->one();


        if (!empty($warehouse)){
            $nProducts = ArrayHelper::map(BaseQuery::getNProductByWarehouse($warehouse['id']), 'id' , 'name' );
        }

        $baseStationWarehouse = ArrayHelper::map(Warehouse::find()->where(['not', ['base_station_id' => null]])->asArray()->all(), 'id' , 'name');


        if (Yii::$app->request->post() ) {
            $post = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            $cont_id = '';
            $com_id = '';
            $dealDataPost = $post['Deal'];
            $C_C_address = $post['ContactAdress'];
            $nProductIds = $post['NomenclatureProduct'];
            $shippingProducts = $post['ShippingProduct'];
            $shippingTypes = $post['Shipping'];
            $baseWarehouses = $post['Warehouse'];
            //varDumper($post);die;

            try {

                # If deal number already exist return message.
                $checkForDealNumberDuplicate = Deal::find()
                    ->where(['deal_number' => $dealDataPost['deal_number']])
                    ->andWhere(['is_active' => Deal::IS_ACTIVE])
                    ->exists();

                if ($checkForDealNumberDuplicate) {
                    Yii::$app->session->setFlash('danger', $dealDataPost['deal_number'] . ' համարը արդեն գոյություն ունի');
                    return $this->redirect(['create']);
                }

                # Create deal
                $model->load($post);

                if($dealDataPost['user_type'] == 0){
                    $crm = $post['Contact'];
                    $model->setNoInternetStatus();
                    if(isset($post['is_new_client'])){
                        $phones = $crm['phone'];
                        unset($crm['phone']);

                        $crmContact->load($post);
                        $crmContact->when_visible = Helper::formatDate($crm['when_visible']);
                        $crmContact->valid_until = Helper::formatDate($crm['valid_until']);
                        $crmContact->dob = Helper::formatDate($crm['dob']);
                        if($crmContact->save()){

                            $contactPassport->contactPassport = UploadedFile::getInstances($contactPassport, 'contactPassport');
                            $contactPassport->upload($crmContact->id);
                            $cont_id = $crmContact->id;
                            if(!empty($phones)) {
                                foreach ($phones as $val) {
                                    $checkPhone = ContactPhone::find()
                                        ->where(['contact_id' => $cont_id])
                                        ->andWhere(['phone' => $val])
                                        ->orWhere(['phone' => ''])
                                        ->one();

                                    if (empty($checkPhone)) {
                                        $ph = new ContactPhone();
                                        $ph->contact_id = $cont_id;
                                        $ph->phone = $val;
                                        $ph->save(false);
                                    }
                                }
                            }
                        }else{
                            $transaction->rollBack();
                        }

                    } else {
                        $cont_id = $dealDataPost['crm_contact_id'];
                    }

                    $model->setContact($cont_id);
                } else {
                    $crm = $post['Company'];
                    $model->disabled_price_deal_c = $dealDataPost['disabled_price_deal_c'];
                    $model->setConnectionDate($dealDataPost['start_day']);
                    $model->setActiveStatus();
                    if (isset($post['is_new_client'])) {
                        $phones = $crm['phone'];
                        unset($crm['phone']);

                        $crmCompany->load($post);

                        $crmCompany->surname = 'fast';
                        $crmCompany->when_visible = Helper::formatDate($crm['when_visible']);
                        $crmCompany->valid_until = Helper::formatDate($crm['valid_until']);
                        if ($crmCompany->save()) {
                            $com_id = $crmCompany->id;
                            if (!empty($phones)) {
                                foreach ($phones as $phone => $val) {
                                    $checkPhone = ContactPhone::find()
                                        ->where(['company_id' => $com_id])
                                        ->andWhere(['phone' => $val])
                                        ->orWhere(['phone' => ''])
                                        ->one();

                                    if (empty($checkPhone)) {
                                        $ph = new ContactPhone();
                                        $ph->company_id = $com_id;
                                        $ph->phone = $val;
                                        $ph->save(false);
                                    }
                                }
                            }
                        } else {
                            $transaction->rollBack();
                        }

                    } else {
                        $com_id = $dealDataPost['crm_company_id'];
                    }

                    $model->setCompany($com_id);
                }

                $deal_addresses = [];

                # If the addresses are taken from select.
                if (isset($post['address_id']) && !empty($post['address_id'])) {
                    foreach ($post['address_id'] as $selectedAddress) {
                        $deal_addresses[] = $selectedAddress;

                        $dealContactAddress = new FDealAddress();
                        $dealContactAddress->deal_number = $model->deal_number;
                        $dealContactAddress->contact_address_id = $selectedAddress;
                        $dealContactAddress->save();
                    }
                } else { # If the addresses are filled out on the form.

                    if (!empty($C_C_address['country_id'])) {

                        foreach ($C_C_address['country_id'] as $k => $add) {
                            $street = Streets::findOne(['id' => intval($C_C_address['street'][$k])]);
                            $streetId = null;

                            if (empty($street) || !$C_C_address['street'][$k]) {
                                $new_street = new Streets();
                                $new_street->name = $C_C_address['street'][$k];
                                $new_street->city_id = $C_C_address['city_id'][$k];
                                $new_street->community_id = $C_C_address['community_id'][$k];

                                if ($new_street->save()) {
                                    $streetId = $new_street->id;
                                }
                            } else {
                                $streetId = $street->id;
                            }

                            $addressForSave = new ContactAdress();
                            $addressForSave->contact_id = $cont_id;
                            $addressForSave->company_id = $com_id;
                            $addressForSave->country_id = $add;

                            if (isset($C_C_address['community_id'][$k])) {
                                $addressForSave->community_id = $C_C_address['community_id'][$k];
                            } else {
                                $addressForSave->community_id = 0;
                            }

                            $addressForSave->region_id = $C_C_address['region_id'][$k];
                            $addressForSave->city_id = $C_C_address['city_id'][$k];
                            $addressForSave->street = $streetId;
                            $addressForSave->house = $C_C_address['house'][$k];
                            $addressForSave->housing = $C_C_address['housing'][$k];
                            $addressForSave->apartment = $C_C_address['apartment'][$k];

                            if ($addressForSave->save()) {

                                if (array_key_exists('product_id', $shippingProducts)){
                                    $whModel = new Warehouse();
                                    $whModel->contact_address_id = $addressForSave->id;
                                    $whModel->created_at  = Carbon::now()->toDateTimeString();
                                    $whModel->type = 'virtual';
                                    foreach ($baseWarehouses['id'] as $value) {
                                        if ($value !== "") {
                                            $whModel->base_station_id = Warehouse::findOne($value)->base_station_id;
                                        }
                                    }
                                    $whModel->save();

                                    $userId = Yii::$app->user->identity->id;
                                    $userWarehouse = Warehouse::find()->select(['id'])->where(['user_id' => $userId])->asArray()->one();

                                    $this->shippingByDeal($nProductIds, $shippingProducts, $shippingTypes, $baseWarehouses, $whModel->id, $userWarehouse['id']);
                                }


                                $dealContactAddress = new FDealAddress();
                                $dealContactAddress->deal_number = $model->deal_number;
                                $dealContactAddress->contact_address_id = $addressForSave->id;
                                $dealContactAddress->save();
                            }

                            $deal_addresses[] = $addressForSave->id;
                        }
                    }
                }

                $model->setContractStart($dealDataPost['contract_start'], $dealDataPost['is_daily']);
                $model->setContractEnd($dealDataPost['contract_end'], $dealDataPost['is_daily']);
                $model->setStartDate($dealDataPost['start_day']);
                $model->setSpeedDateStart($dealDataPost['speed_date_start']);
                $model->setSpeedDateEnd($dealDataPost['speed_date_end']);
                $model->setIsWifi($dealDataPost['is_wifi']);
                $model->setBlacklist($post['blacklist']);

                $model->setIsDaily($dealDataPost['is_daily']);
                $model->setDailyFinishMonth($dealDataPost['daily_finish_month'], $dealDataPost['is_daily']);
                $model->setMonth($dealDataPost['daily_finish_month'], $dealDataPost['is_daily']);

                if (isset($dealDataPost['is_daily'])) {
                    $model->setDailyMonthEnd();
                }

                if ($model->save()) {

                    // Insert IP list and toggle status
                    if (!empty($dealDataPost['base_station_ip'])) {
                        foreach ($dealDataPost['base_station_ip'] as $ip) {
                            $setNewIps = new BaseStationsIp();
                            $setNewIps->deal_number = $model->deal_number;
                            $setNewIps->ip_id = $ip;
                            $setNewIps->save();

                            IpAddresses::IPAddressStatus($ip, 3);
                        }
                    }

                    # Insert antenna IPs
                    if (!empty($dealDataPost['antenna_ip']) && $dealDataPost['connect_type'] == 2) {
                        foreach ($dealDataPost['antenna_ip'] as $ip) {
                            $antennaIp = new DealAntennaIp();
                            $antennaIp->deal_number = $model->deal_number;
                            $antennaIp->antenna_ip_id = $ip;
                            $antennaIp->save();
                        }
                    }

                    if (!empty($dealDataPost['ip'][0])) {
                        foreach($dealDataPost['ip'] as $s => $addrs){
                            $ip = new DealIp();
                            $ip->deal_number = $model->deal_number;
                            $ip->address = $addrs;
                            $ip->status = isset($dealDataPost['ip_status']) && in_array($s, $dealDataPost['ip_status']) ? 1 : 0;
                            $ip->save();
                        }
                    }

                    if (!empty($deal_addresses)) {
                        for ($i = 0; $i < count($deal_addresses); $i++) {
                            $deal_address = new DealAddress();
                            $deal_address->deal_id = $model->id;
                            $deal_address->address_id = $deal_addresses[$i];
                            $deal_address->save();
                        }
                    }

//                    $whModel->created_at  = Carbon::now()->toDateTimeString();
//                    $whModel->type = 'virtual';
//                    $whModel->save();

                    $transaction->commit();
                    
                    Yii::$app->session->setFlash('success', 'Պայմանագիրը ստեղծվել է');

                    return $this->redirect(['index']);

                } else {
                    $transaction->rollBack();
                }

            } catch (\Exception $e) {
                Yii::$app->session->setFlash('danger', 'Պայմանագիրը չի ստեղծվել');
                echo $e->getLine() . ' - ' . $e->getMessage();
                $transaction->rollBack();
            }
        }

        return $this->render('create', [
            'model' => $model,
            'crmContact' => $crmContact,
            'crmCompany' => $crmCompany,
            'address' => $address,
            'contactPassport' => $contactPassport,
            'antennaIp' => $antennaIp,
            'nProducts' => $nProducts,
            'nProduct' => $nProduct,
            'shippingProduct' => $shippingProduct,
            'baseWarehouse' => $baseWarehouse,
            'shipping' => $shipping,
            'baseStationWarehouse' => $baseStationWarehouse
        ]);
    }



    /**
     * Updates an existing Deal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel(Deal::class, $id);

        $ipAddresses = DealIp::find()->where(['deal_number' => $model->deal_number])->all();

        if (Yii::$app->request->post() ) {
            $post = Yii::$app->request->post();

            $transaction = Yii::$app->db->beginTransaction();
            $dealDataPost = $post['Deal'];

            try {

                # Keep speed changed attributes.
                $oldBindingSpeed = $model->oldAttributes['binding_speed'];
                $oldDownBindingSpeed = $model->oldAttributes['down_binding_speed'];
                $oldSpeedDateStart = $model->oldAttributes['speed_date_start'];
                $oldSpeedDateEnd = $model->oldAttributes['speed_date_end'];

                /** If service change is checked and Service/Packet is changed - return bool */
                $serviceChanged = (isset($dealDataPost['service_change']) && $dealDataPost['service_change'] == 1 && $model->connect_id != $dealDataPost['connect_id']);

                if ($serviceChanged) {

                    $model->setSuspendedStatus(); // Suspend current deal
                    $model->is_active = Deal::INACTIVE; // Set previous deal active status to inactive

                    /** @var $changeDeal - New deal with changed tariff */
                    $changeDeal = new Deal();

                    $changeDeal->load($post);

                    $changeDeal->deal_number = $model->deal_number;
                    $changeDeal->contact_id = $model->contact_id;
                    $changeDeal->user_type = $model->user_type;
                    $changeDeal->setContact($model->crm_contact_id);
                    $changeDeal->setCompany($model->crm_company_id);
                    $changeDeal->amount = $model->amount;
                    $changeDeal->service_type = $dealDataPost['service_type'];
                    $changeDeal->connect_id = $dealDataPost['connect_id'];
                    $changeDeal->setActiveStatus();
                    $changeDeal->setConnectPrice($dealDataPost['connect_price']);
                    $changeDeal->setConnectionDate();
                    $changeDeal->setContractStart($model->contract_start);
                    $changeDeal->setContractEnd($model->contract_end);
                    $changeDeal->setStartDate($model->start_day);
                    $changeDeal->setSpeedDateStart($model->speed_date_start);
                    $changeDeal->setSpeedDateEnd($model->speed_date_end);
                    $changeDeal->setIsWifi($model->is_wifi);
                    $changeDeal->is_active = Deal::IS_ACTIVE;
                    $changeDeal->setBlacklist($post['blacklist']);
                    if($changeDeal->save()) {
                        $disabledPrice = DisabledDay::disabledPrice();

                        // Previews suspended model old balance.
                        $previousPricing = new Pricing($model);
                        $previousModelBalance = $previousPricing->oldBalance($changeDeal);
                        $changeBalanceStock = $model->balance->balance - $model->tariff->inet_price;

                        $ress = $changeBalanceStock + $previousModelBalance;
                        $oldBalance = $model->balance;
                        $oldBalance->balance = $ress;
                        $oldBalance->save();

                        // New deal price calculation with old balance.
                        $newModelPricing = new Pricing($changeDeal);
                        $newDealBalance = (($newModelPricing->virtualBalance(false, $changeDeal->connection_day) + $ress + $model->connect_price) - $previousPricing->currentMonthTotalPayed());
                        $newBalance = new DealBallance();
                        $newBalance->balance = $newDealBalance;
                        $newBalance->deal_id = $changeDeal->id;
                        $newBalance->date = Carbon::now()->format('Y-m-d');
                        $newBalance->deal_number = $changeDeal->deal_number;
                        $newBalance->save();
                    }

                } else {
                    $balanceUpdate = DealBallance::findOne(['deal_id' => $model->id]);
                    if($balanceUpdate){

                        $electricityUp = ($model->electricity ?: 0) - ($dealDataPost['electricity'] ?: 0);

                        $discountUp = ($model->discount ?: 0) - ($dealDataPost['discount'] ?: 0);

                        $totalDisUp = (int)$electricityUp + (int)$discountUp;

                        $balanceUpdate->balance += $totalDisUp;
                        $balanceUpdate->save();
                    }
                    $model->load($post);
                    $model->setContractStart($model->contract_start);
                    $model->setContractEnd($model->contract_end);
                    $model->setSpeedDateStart($model->speed_date_start);
                    $model->setSpeedDateEnd($model->speed_date_end);
                    $model->setIsWifi($dealDataPost['is_wifi']);
                    $model->setBlacklist($post['blacklist']);


                }

                if($model->save()) {

                    # Insert IP list and toggle status
                    if (!empty($dealDataPost['base_station_ip'])) {

                        /** Active status for existing IP */
                        if (!empty($model->ips)) {
                            $model->relationIPAddressStatus(1);
                        }

                        // Remove current deal ip list
                        BaseStationsIp::deleteAll(['deal_number' => $model->deal_number]);

                        foreach ($dealDataPost['base_station_ip'] as $ip) {

                            /** Deactivate status for new IP */
                            IpAddresses::IPAddressStatus($ip, 3);

                            $setNewIps = new BaseStationsIp();
                            $setNewIps->deal_number = $model->deal_number;
                            $setNewIps->ip_id = $ip;
                            $setNewIps->save();
                        }
                    }

                    # Insert antenna IPs
                    if (!empty($dealDataPost['antenna_ip']) && $dealDataPost['connect_type'] == 2) {
                        DealAntennaIp::deleteAll(['deal_number' => $model->deal_number]);

                        foreach ($dealDataPost['antenna_ip'] as $ip) {
                            $antennaIp = new DealAntennaIp();
                            $antennaIp->deal_number = $model->deal_number;
                            $antennaIp->antenna_ip_id = $ip;
                            $antennaIp->save();
                        }
                    }

                    if(!empty($dealDataPost['ip'][0])) {
                        DealIp::deleteAll(['deal_number' => $model->deal_number]);

                        foreach($dealDataPost['ip'] as $s => $addrs) {
                            $ip = new DealIp();
                            $ip->deal_number = $model->deal_number;
                            $ip->address = $addrs;
                            $ip->status = isset($dealDataPost['ip_status']) && in_array($s, $dealDataPost['ip_status']) ? 1 : 0;
                            $ip->save();
                        }
                    }

                    # Check if speed changed.
                    if ($model->binding_speed != $oldBindingSpeed ||
                        $model->speed_date_start != $oldSpeedDateStart ||
                        $model->speed_date_end != $oldSpeedDateEnd || $model->down_binding_speed != $oldDownBindingSpeed
                    ) {
                        $mikrotik = new ManageMikrotik($model);
                        $mikrotik->setUpdateMode(true);
                        $mikrotik->updateFirewall();
                    }

                    $transaction->commit();

                    return $this->redirect(['index']);
                } else {
                    $transaction->rollBack();
                }

            } catch (\Exception $e) {
                echo 'Code: ' . $e->getCode() . ' - ' . $e->getMessage() . '. On line: ' . $e->getLine() . '. Trace: ' . $e->getTraceAsString() . '. File: ' . $e->getFile();
                $transaction->rollBack();
            }
        }

        $model->connect_price = Helper::removeUselessZeroDigits($model->connect_price);
        $model->penalty = Helper::removeUselessZeroDigits($model->penalty);
        $model->discount = Helper::removeUselessZeroDigits($model->discount);
        $model->electricity = Helper::removeUselessZeroDigits($model->electricity);

        $model->contract_start = Helper::formatDate($model->contract_start, false, true);
        $model->contract_end = Helper::formatDate($model->contract_end, false, true);
        $model->connection_day = Helper::formatDate($model->connection_day);
        $model->speed_date_start = Helper::formatDate($model->speed_date_start, false, true);
        $model->speed_date_end = Helper::formatDate($model->speed_date_end, false, true);

        return $this->render('update', [
            'model' => $model,
            'ipAddresses' => $ipAddresses
        ]);
    }

    /**
     * Deletes an existing Deal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel(Deal::class, $id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @return array|false
     */
    public function actionGetIps()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(!Yii::$app->request->isAjax) {
            return false;
        }

        $base_id = intval(Yii::$app->request->post()['base_id']);

        if (isset(Yii::$app->request->post()['id'])) {
            $model = Deal::find()
                ->andWhere(['is_active' => Deal::IS_ACTIVE])
                ->andWhere(['deal_number' => Yii::$app->request->post()['id']])
                ->one();

            if (!empty($model)) {
                return IpAddresses::all($base_id, ArrayHelper::getColumn($model->ipAddress, 'id'));
            }
        }

        return IpAddresses::all($base_id);
    }

    public function actionGetAntenna()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(!Yii::$app->request->isAjax) {
            return false;
        }

        $base_id = intval(Yii::$app->request->post()['base_station_id']);
        return AntennaIp::all($base_id);
    }

    /**
     * @return array|false
     */
    public function actionGetServices()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!Yii::$app->request->isAjax) {
            return false;
        }

        $type = intval(Yii::$app->request->post()['type']);
        return Deal::getAllTariffsByType($type);
    }

    /**
     * @return false|int
     */
    public function actionConnectPrice()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!Yii::$app->request->isAjax) {
            return false;
        }

        $connect_id = intval(Yii::$app->request->post()['connect_id']);

        $tariff = Tariff::findOne($connect_id);

        $price = $tariff->tv_id ? (($tariff->inet_price ? $tariff->inet_price : 0 ) + $tariff->tv->price): $tariff->inet_price;
        varDumper($price);die;
        return  Helper::removeUselessZeroDigits($price);
    }

    /**
     * @return array
     */
    public function actionGetRegionsByCountry() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $post = Yii::$app->request->post();
        if (empty($post['id'])) {
            return [];
        }

        return BaseQuery::renderRegions($post['id']);
    }

    /**
     * @return array|array[]
     */
    public function actionGetStreetsByCity() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $post = Yii::$app->request->post();
        $data = [];
        if (empty($post['id'])) {
            return [];
        }
        $data['streets'] = BaseQuery::renderStreets($post['id']);
        $data['communities'] = BaseQuery::renderCommunity($post['id']);

        return $data;
    }

    /**
     * @return array|array[]
     */
    public function actionGetStreetsByCommunity(Request $request) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data = [];
        if (empty($request->post('id'))) {
            return [];
        }
        $data['streets'] = BaseQuery::renderStreets($request->post('id'), true);

        return $data;
    }

    /**
     * @return array
     */
    public function actionGetDealsByCity() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $post = Yii::$app->request->post();

        if (empty($post['id'])) {
            return [];
        }

        return $this->renderAjax('@fastnet/views/_partials/_check_deals', ['model' => BaseQuery::renderDeals($post['id'], isset($post['baseStation']))]);
    }

    /**
     * @return array|array[]
     */
    public function actionGetCitiesByRegion() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $post = Yii::$app->request->post();

        if (empty($post['id'])) {
            return [];
        }

        return BaseQuery::renderCities($post['id']);
    }

    public function actionGetTotalPrice() {

        if (Yii::$app->request->isAjax) {
            $deal = Deal::findOne(['id' => intval(Yii::$app->request->post()['id'])]);

            $pricing = new Pricing($deal);

            $total_deal_amount  = $pricing->totalDealAmount() + $pricing->sumIPPrice();

            $helper = new Helper();
            $balance = $helper->mathPriceMonth($total_deal_amount, $deal->connection_day, date('Y-m-d'));

            $penaltyPrice = $deal->penalty ?: 0;
            $servicePrice = ($balance + $pricing->sumIPPrice() + $deal->connect_price) - $pricing->currentMonthTotalPayed();
            $totalPaid = $penaltyPrice + $servicePrice;

            // If deal has penalty, hide/show in popup
            $hasPenalty = (bool) $deal->penalty;

            $contractEnd = '';
            $remainsDay = '';
            if ($deal->contract_start && $deal->contract_end) {
                $contractEnd = Helper::formatDate($deal->contract_end, false, true);
                $remainsDay = Helper::dateDifference($deal->contract_end);
            }

            return Json::encode([
                'penalty' => round($penaltyPrice),
                'service' => round($servicePrice),
                'total' => round($totalPaid),
                'hasPenalty' => $hasPenalty,
                'contractEnd' => $contractEnd,
                'remainsDay' => $remainsDay
            ]);
        }
    }

    public function actionGetAddressesByCustomer(Request $request) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($request->isAjax) {
            if ($request->post('customer_type') == 1) {
                $customer = Contact::findOne($request->post('customer'));
            } else {
                $customer = Company::findOne($request->post('customer'));
            }

            $options = [];

            if (!empty($customer) && !empty($customer->contactAddress)) {
                $addresses = [];
                if(!empty($customer->contactAddress)) {
                    foreach ($customer->contactAddress as $addr => $address) {
                        $region = !empty($address->region->name) ? $address->region->name : '';

                        $city = '';
                        $house = '';
                        $apartment = '';

                        if (!empty($address->city)) {
                            if ($address->city->city_type_id == 1) {
                                $city .= ', ք․ ';
                            } elseif ($address->city->city_type_id == 3) {
                                $city .= ', գ․ ';
                            }

                            $city .= $address->city->name;
                        }

                        $street = !empty($address->street) ? ', փ․ ' . $address->fastStreet->name : '';

                        if (!empty($address->house)) {
                            if (!empty($address->apartment)) {
                                $house .= ', շ․ ';
                            } else {
                                $house .= ', տ․ ';
                            }

                            $house .= $address->house;
                        }

                        if (!empty($address->apartment)) {
                            if ($address->house) {
                                $apartment .= ', բն․ ';
                            } else {
                                $apartment .= ', տ․ ';
                            }

                            $apartment .= $address->apartment;
                        }

                        $entrance = !empty($address->housing) ? ', մ․ ' . $address->housing : '';

                        $addresses[$address['id']] = $region . $city . $street . $house . $entrance . $apartment;
                    }
                }

                foreach ($addresses as $key => $address) {
                    $options[] = ['id' => $key, 'text' => $address];
                }
            }

            return $options;
        }
    }

    /**
     * Preview deal agreement in new tab
     *
     * @param $id
     * @return \yii\console\Response|\yii\web\Response
     */
    public function actionPreviewAgreement($id) {
        $model = $this->findModel(DealAgreement::class, $id);

        return Yii::$app->response->sendFile(Yii::getAlias('@webroot') . "/agreements/".$model->file, $model->file, ['inline'=>true]);
    }

    /**
     * Download deal agreement
     *
     * @param $id
     * @return \yii\console\Response|\yii\web\Response
     */
    public function actionDownloadAgreement($id) {
        $model = $this->findModel(DealAgreement::class, $id);

        return Yii::$app->response->xSendFile(Yii::getAlias('@webroot') . "/agreements/".$model->file);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Mpdf\MpdfException
     * @throws \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     * @throws \setasign\Fpdi\PdfParser\Type\PdfTypeException
     * @throws \yii\base\InvalidConfigException
     */
//    public function actionSendAgreement(Request $request) {
//        if ($request->isAjax) {
//            $deal = Deal::find()
//                ->dealNumberIs($request->post('deal_number'))
//                ->dealIsActive()
//                ->one();
//
//            if ($deal->crm_contact_id) {
//                $customer = $deal->crmContact;
//            }
//
//            $pricing = new Pricing($deal);
//
//            $agreementVariables = [
//                'number' => $deal->deal_number,
//                'date' => TimeHelper::localizedDate($deal->create_at),
//                'customer' => $customer->name . ' ' . $customer->surname,
//                'passport_number' => $customer->passport_number,
//                'passport_was_given' => !empty($customer->when_visible) ? date('d.m.Y', strtotime($customer->when_visible)) : null,
//                'passport_from_whom' => $customer->visible_by,
//                'penalty' => !empty($deal->penalty) ? $deal->penalty : 0,
//                'penalty_string' => Helper::numberToWords($deal->penalty),
//                'agreement_enters_into_force_year' => date('Y', strtotime($deal->create_at)),
//                'agreement_enters_into_force_month' => 24,
//                'agreement_enters_into_force_month_string' => Helper::numberToWords(24),
//                'email' => $customer->email,
//                'phone' => $customer->contactPhone ? $customer->contactPhone[0]->phone : null,
//                'paid_contract_for_cable_tv_internet_access_date' => TimeHelper::localizedDate(date('Y-m-d')),
//                'service_price_internet' => $deal->service_type == 1 ? $pricing->totalDealAmount(false) : 0,
//                'service_price_tv' => $deal->service_type == 2 ? $pricing->totalDealAmount(false) : 0,
//
//                'service_price_internet_string' => $deal->service_type == 1 ? Helper::numberToWords($pricing->totalDealAmount(false)) : null,
//                'service_price_tv_string' => $deal->service_type == 2 ? Helper::numberToWords($pricing->totalDealAmount(false)) : null,
//
//                'service_internet' => $deal->service_type == 1 ? $deal->tariff->name : null,
//                'service_tv' => $deal->service_type == 2 ? '-' : null,
//                'service_address_internet' => $deal->service_type == 1 ? $deal->formatedAddress() : null,
//                'service_address_tv' => $deal->service_type == 2 ? $deal->formatedAddress() : null,
//                'service_ip_count' => $deal->getDealIp()->count(),
//                'service_ip_price' => $deal->getDealIp()->count() > 0 ? 1000 : 0,
//                'service_ip_total_price' => $pricing->sumIPPrice(),
//            ];
//
//            $filename = $deal->deal_number . '_' . time() . '.pdf';
//
//            $html = $this->renderPartial('@app/mail/layouts/deal_agreement', ['model' => $agreementVariables]);
//
////            return file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/test.pdf', $output);
//
//            // setup kartik\mpdf\Pdf component
//            $pdf = new Pdf([
//                // set to use core fonts only
//                'mode' => Pdf::MODE_UTF8,
//                // A4 paper format
//                'format' => Pdf::FORMAT_A4,
//                // portrait orientation
//                'orientation' => Pdf::ORIENT_PORTRAIT,
//                // stream to browser inline
//                'destination' => Pdf::DEST_FILE,
//                'filename' => $filename,
//                // your html content input
//                'content' => $html,
//                // format content from your own css file if needed or use the
//                // enhanced bootstrap css built by Krajee for mPDF formatting
////                'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
//                // any css to be embedded if required
////                'cssInline' => $css,
//            ]);
//
//            return $pdf->render();
//
////            $pdf = new Pdf([
////                // set to use core fonts only
////                'mode' => Pdf::MODE_UTF8,
////                // A4 paper format
////                'format' => Pdf::FORMAT_A4,
////                // portrait orientation
////                'orientation' => Pdf::ORIENT_PORTRAIT,
////                // stream to browser inline
////                'destination' => Pdf::DEST_FILE,
////                'filename' => 'ttttt.pdf',
////                // your html content input
////                'content' => $html,
////                // format content from your own css file if needed or use the
////                // enhanced bootstrap css built by Krajee for mPDF formatting
//////                'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
////                // any css to be embedded if required
////                'cssInline' => $css,
////            ]);
////            return $pdf->render();
//
////            return Yii::$app->response->sendFile();
//        }
//    }

    /**
     * @param null $q
     * @param null $id
     * @return array
     */
    public function actionSearchDeal($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $result = [];

        $tariffSearchQuery = Tariff::find()
            ->select('id, name')
            ->where(['LIKE', 'name', $q . '%', false])
            ->all();

        foreach ($tariffSearchQuery as $tariff) {
            $result[] = ['id' => $tariff->id, 'text' => $tariff->name];
        }

        $out['results'] = $result;
        return $out;
    }

    /**
     * Search physical person for gridview filter.
     *
     * @param null $q
     * @param null $id
     * @return array
     */
    public function actionSearchPhysicalPerson($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $result = [];

        $contactSearchQuery = Contact::find()
            ->select('id, name, surname')
            ->where(['LIKE', 'name', $q . '%', false])
            ->orWhere(['LIKE', 'surname', $q . '%', false])
            ->all();

        foreach ($contactSearchQuery as $contact) {
            $result[] = ['id' => $contact->id, 'text' => $contact->name . ' ' . $contact->surname];
        }

        $out['results'] = $result;
        return $out;
    }

    /**
     * Search company for gridview filter.
     *
     * @param null $q
     * @param null $id
     * @return array
     */
    public function actionSearchCompany($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $result = [];

        $companySearchQuery = Company::find()
            ->select('id, name')
            ->where(['LIKE', 'name', $q . '%', false])
            ->all();

        foreach ($companySearchQuery as $company) {
            $result[] = ['id' => $company->id, 'text' => $company->name];
        }

        $out['results'] = $result;
        return $out;
    }

    public function actionImportDeal(Request $request)
    {
//        varDumper($_FILES);die;
        $importer = new Importer();
//        $importer->tempFile = $_FILES['import_deal_field']['name'];
        varDumper($importer->read());die;
    }

    public function shippingByDeal($nProductIds, $shippingProducts, $shippingTypes, $baseWarehouses, $contactWarehouseId, $userWarehouseId){
        for ($i = 0; $i < count($shippingProducts['product_id']) ; $i++) {
            if ($shippingProducts['product_id'][$i] !== ""){
                $shipping = new Shipping();
                $shpippingProduct = new ShippingProduct();
                if ($baseWarehouses['id'][$i] !== "") {
                    $shipping->created_at  = Carbon::now()->toDateTimeString();
                    $shipping->provider_warehouse_id = $userWarehouseId;
                    $shipping->supplier_warehouse_id = $baseWarehouses['id'][$i];
                    $shipping->shipping_type = $shippingTypes['shipping_type'][$i];
                    $shipping->status = 'Հաստատված';
                    $shipping->save();
                } else {
                    $shipping->created_at  = Carbon::now()->toDateTimeString();
                    $shipping->provider_warehouse_id = $userWarehouseId;
                    $shipping->supplier_warehouse_id = $contactWarehouseId;
                    $shipping->shipping_type = $shippingTypes['shipping_type'][$i];
                    $shipping->status = 'Հաստատված';
                    $shipping->save(false);
                }
                $shpippingProduct->created_at = Carbon::now()->toDateTimeString();
                $shpippingProduct->shipping_id = $shipping->id;
                $shpippingProduct->product_id = $shippingProducts['product_id'][$i];
                $shpippingProduct->save(false);
                $product = Product::findOne($shippingProducts['product_id'][$i]);
                $product->warehouse_id = $shipping->supplier_warehouse_id;
                $product->save(false);
            } else {
                $shipping = new Shipping();
                $shpippingProduct = new ShippingProduct();
                $nProducts = Product::find()->where(['warehouse_id' => $userWarehouseId, 'nomenclature_product_id' => $shippingProducts['product_individual_id'][$i]])
                ->orderBy(['created_at' => SORT_ASC])
                ->all();
                foreach ($nProducts as $nProduct) {
                    if ($nProduct->count > $shippingProducts['count'][$i]) {
                        $newProduct = new Product();
                        $newProduct->price = $nProduct->price;
                        $newProduct->retail_price = $nProduct->retail_price;
                        $newProduct->supplier_name = $nProduct->supplier_name;
                        $newProduct->mac_address = $nProduct->mac_address;
                        $newProduct->comment = $nProduct->comment;
                        $newProduct->used = $nProduct->used;
                        $newProduct->created_at = $nProduct->created_at;
                        $newProduct->nomenclature_product_id = $nProduct->nomenclature_product_id;
                        $newProduct->warehouse_id = $contactWarehouseId;
                        $newProduct->count = $shippingProducts['count'][$i];
                        $countProduct = $nProduct->count - $shippingProducts['count'][$i];
                        $nProduct->count = $countProduct;

                        $newProduct->save(false);
                        $nProduct->save(false);

                        $shipping->created_at  = Carbon::now()->toDateTimeString();
                        $shipping->provider_warehouse_id = $userWarehouseId;
                        $shipping->supplier_warehouse_id = $contactWarehouseId;
                        $shipping->shipping_type = $shippingTypes['shipping_type'][$i];
                        $shipping->status = 'Հաստատված';
                        $shipping->save();
                        $shpippingProduct->created_at = Carbon::now()->toDateTimeString();
                        $shpippingProduct->shipping_id = $shipping->id;
                        $shpippingProduct->product_id = $newProduct->id;
                        $shpippingProduct->save(false);
                        break;
                    } else {
                        $shipping->created_at  = Carbon::now()->toDateTimeString();
                        $shipping->provider_warehouse_id = $userWarehouseId;
                        $shipping->supplier_warehouse_id = $contactWarehouseId;
                        $shipping->shipping_type = $shippingTypes['shipping_type'][$i];
                        $shipping->status = 'Հաստատված';
                        $shipping->save();
                        $shpippingProduct->created_at = Carbon::now()->toDateTimeString();
                        $shpippingProduct->shipping_id = $shipping->id;
                        $shpippingProduct->product_id = $nProduct->id;
                        $shpippingProduct->save(false);
                        $nProduct->warehouse_id = $contactWarehouseId;
                        $nProduct->save(false);
                        $shippingProducts['count'][$i] = $shippingProducts['count'][$i] -= $nProduct->count ;

                    }
                }

            }

        }
    }

    public function actionGetMacAddressByWarehouse() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $userId = Yii::$app->user->identity->id;
        $warehouse = Warehouse::find()->select(['id'])->where(['user_id' => $userId])->asArray()->one();

        $post = Yii::$app->request->post();

        if (empty($post['n_product_id'])) {
            return [];
        }

        $data_sipping = [
            'count_partial' => $this->renderPartial('@fastnet/views/deal/partial/nomenclature_product_individual_count'),
            'mac_partial' => $this->renderPartial('@fastnet/views/deal/partial/product_mac_address'),
            'data_nProducts' => BaseQuery::renderProductMacAddres($post['n_product_id'] ,$warehouse['id'])
        ];



        return $data_sipping;
    }
}
