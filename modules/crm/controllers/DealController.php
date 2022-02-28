<?php

namespace app\modules\crm\controllers;

use app\components\FileUpload;

use app\modules\billing\models\DealPaymentLog;
use app\modules\billing\models\IpAddresses;
use app\modules\billing\models\Share;
use app\modules\billing\models\ShareTariffConfig;
use app\modules\billing\models\TableSearch;
use app\modules\billing\models\TableSettings;
use app\modules\billing\models\Tariff;
use app\modules\crm\models\CrmDealVacation;
use app\modules\crm\models\DealAddress;
use app\modules\crm\models\DealConect;
use app\modules\billing\models\query\BillingQuery;
use app\modules\billing\models\ServiceCountry;
use app\modules\billing\models\Services;
use app\modules\billing\models\ServiceTariff;
use app\modules\crm\models\ContactAdress;
use app\modules\crm\models\CrmCustomFields;
use app\modules\crm\models\CrmCustomList;
use app\modules\crm\models\CrmDealFile;
use app\modules\crm\models\CrmFieldType;
use app\modules\crm\models\CrmFieldValue;
use app\modules\crm\models\CrmSection;
use app\modules\crm\models\CrmStatus;
use app\modules\crm\models\DealIp;
use app\modules\crm\models\Product;
use Yii;
use app\modules\crm\models\Deal;
use app\modules\crm\models\DealSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * DealController implements the CRUD actions for Deal model.
 */
class DealController extends Controller
{
    private $menu_id = 5;
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
        $dataProvider = $searchModel->search_new();
//        $searchModel->cloneDeal();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * @return string
     */
    public function actionCalendar(){
        return $this->render('calendar');
    }

    public function actionCalendarList(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(\Yii::$app->request->isAjax){
            $dealData = new Deal();
            //return Ride::getRideListForCalendar();
            return $dealData->CalendarData();
        }
    }
    /**
     * @return string
     */
    public function actionMaintenance()
    {
        $dealData = new Deal();
        $deals = $dealData->kanbanData(1);
        return $this->render('kanban', ['deals' => $deals,'type'=>'main']);
    }
    public function actionKanban()
    {
        $dealData = new Deal();
        $deals = $dealData->kanbanData(2);
        return $this->render('kanban', ['deals' => $deals,'type'=>'conn']);
    }
    /**
     * Displays a single Deal model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Deal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Deal();
        $model->name = $this->setDealNumber();
        $responsible = BillingQuery::staff()['Staff'];
        $responsibles = [];
        for ($i =0; $i<count($responsible); $i++){
            $responsibles[$responsible[$i]['id']] = $responsible[$i]['name'];
        }
        $statuses_ = CrmStatus::find()->where(['menu_id' => $this->menu_id, 'type_id' => 1])->all();
        $sections = CrmSection::find()->where(['menu_id' => $this->menu_id])->all();
        $input_types = CrmFieldType::find()->all();
        $statuses_obj = $statuses_;
        $statuses = [];
        if(!empty($statuses_obj)) {
            foreach ($statuses_obj as $status => $val) {
                $statuses[$val->id] = $val->name;
            }
        }
        // Show popup
        if(Yii::$app->request->isAjax) {

            return $this->renderAjax('_form', [
                'responsibles'=>$responsibles,
                'statuses' => $statuses,
                'input_types' => $input_types,
                'statuses_type' => $statuses_,
                'type' => 1,
                'model' => $model,
                'sections' => $sections
            ]);

        } else {
            if (Yii::$app->request->post()) {

                $post = Yii::$app->request->post();
                $deal_connect = Yii::$app->request->post('Deal_connect');
                $deal_address = Yii::$app->request->post('Deal_address');
                $shareData = Yii::$app->request->post('Tariff');
                $payment = Yii::$app->request->post('Deal')['payment'];

                $model->load($post);

                if(!Yii::$app->request->post('is_share')){
                    if(!empty($shareData) && isset($shareData['share_type'])){
                        $res = $this->addShare($shareData, $model);
                        $model->share_id = $res;
                    } else {
                        $model->share_id = null;
                    }
                }

                $model->deal_type_id = 1;
                if ($model->save()) {
                    if (!empty($post['Fields'])) {
                        foreach ($post['Fields'] as $field => $value) {
                            $Cfield = new CrmFieldValue();
                            $Cfield->field_id = $field;
                            $Cfield->value = $value;
                            $Cfield->column_id = $model->id;
                            $Cfield->save();
                        }
                    }
                }
                if(intval($payment)){
                    $payment_log = new DealPaymentLog();
                    $payment_log->deal_id = $model->id;
                    $payment_log->price = $payment;
                    $payment_log->create_at = date("Y-m-d H:i:s");
                    $payment_log->save();
                }
                 if(isset($post['ip_address'])){
                     foreach ($post['ip_address'] as $ipaddress => $ipaddress_val){
                         $dealIp = new DealIp();
                         $dealIp->deal_id = $model->id;
                         $dealIp->ip_id = $ipaddress_val;
                         if($dealIp->save()) {
                             $ip = IpAddresses::find()->where(['id'=>$ipaddress_val])->one();
                             $ip->status = 3;
                             $ip->save();
                         }
                     }
                 }
                if(isset($deal_address)){
                    foreach ($deal_address as $address => $address_val){
                        $dealAddress = new DealAddress();
                        $dealAddress->deal_id = $model->id;
                        $dealAddress->address_id = $address_val;
                        $dealAddress->save();
                    }
                }
                if(isset($deal_connect['product_id'])){
                    foreach ($deal_connect['product_id'] as $key => $product){
                        if($deal_connect['product_id'][$key]) {
                            $productInfo = Product::findOne($deal_connect['product_id'][$key]);
                            $dealConect = new DealConect();
                            $dealConect->deal_id = $model->id;
                            $dealConect->product_id = $deal_connect['product_id'][$key];
                            $dealConect->edit_date = $deal_connect['edit_date'];
                            $dealConect->installer_id = $deal_connect['installer_id'];
                            $dealConect->eq_type = $deal_connect['eq_type'][$key];
                            $dealConect->product_id = $deal_connect['product_id'][$key];
                            $dealConect->count = $deal_connect['count'][$key];
                            $dealConect->mac_address = $deal_connect['mac_address'][$key];
                            $dealConect->ip_address = $deal_connect['ip_address'][$key];
                            $dealConect->location = $deal_connect['location'][$key];
                            $dealConect->area = $deal_connect['area'][$key];
                            $dealConect->product_price = $productInfo->base_amount;
                            $dealConect->product_unit_id = $productInfo->unit_id;
                            $dealConect->basis = $deal_connect['basis'][$key];
                            $dealConect->save();
                        }
                    }
                }

                if (!empty($_FILES)) {

                    $uploadTmp = $_FILES['file']['tmp_name'];
                    $uploadType = $_FILES['file']['name'];
                    if (!is_dir('deals')) {
                        mkdir('deals', 0777, true);
                    }
                    $path = 'deals/';
                    foreach($uploadType as $key => $val){
                        $ext = pathinfo($val, PATHINFO_EXTENSION);
                        $name = microtime() . '.' . $ext;
                        $name = str_replace(' ', '', $name);
                        $uploadfile = $path . $name;
                        if(move_uploaded_file($uploadTmp[$key], $uploadfile)){
                            $image = new CrmDealFile();
                            $image->deal_id = $model->id;
                            $image->file = $name;
                            $image->save();
                        }
                    }
                }

                return $this->redirect(['index']);

            }

            return $this->render('create', [
                'input_types' => $input_types,
                'model' => $model,
                'sections' => $sections
            ]);
        }
    }
    /**
     * Updates an existing Deal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionTerminateDeal(){
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $id = $post['id'];
            $model = $this->findModel($id);
            $model->deal_end_status = 0;
            return $model->save();
        }
    }
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $vacation =  CrmDealVacation::find()->where(['deal_id'=>$id])->one();
        if(!$vacation){
            $vacation = new CrmDealVacation();
        }
        $sections = CrmSection::find()->where(['menu_id'=>$this->menu_id])->all();
        $input_types = CrmFieldType::find()->all();
        $field_values = CrmFieldValue::find()->where(['column_id'=>$id])->all();
        $statuses_obj = CrmStatus::find()->where(['menu_id' => $this->menu_id,'type_id' => $model->deal_type_id])->orderBy(['ordering'=>SORT_ASC])->all();
        $connects = DealConect::getConnectsByType($id);
        $responsible = BillingQuery::staff()['Staff'];
        $responsibles = [];

        for ($i =0; $i<count($responsible); $i++){
            $responsibles[$responsible[$i]['id']] = $responsible[$i]['name'];
        }
        if(!empty($statuses_obj)) {
            foreach ($statuses_obj as $status => $val) {
                $statuses[$val->id] = $val->name;
            }
        }
        $fields = [];
        foreach ($field_values as $field=> $value ){
            $fields[$value->field_id] = $value->value;
        }

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $status = CrmStatus::find()->where(['id' => $model->status_id])->one();

            $model->load($post);

            if($status->status_type < 3){
                $next = $status->status_type+1;
                $next_status = CrmStatus::find()->where(['menu_id' => $this->menu_id,'type_id' => $model->deal_type_id,'status_type'=>$next])->one();
                $model->status_id = $next_status->id;
            }
            $model->save();
            $deal_connect = Yii::$app->request->post('Deal_connect');
            $deal_address = Yii::$app->request->post('Deal_address');
            $new_connect = Yii::$app->request->post('New_deal_connect');
            $payment = intval(Yii::$app->request->post('Deal')['payment']);

            if($payment){
                $payment_log = new DealPaymentLog();
                $payment_log->deal_id = $model->id;
                $payment_log->price = $payment;
                $payment_log->create_at = date("Y-m-d H:i:s");
                $payment_log->save();
            }
            if(isset($deal_address)){
                foreach ($deal_address as $address => $address_val){
                    $dealAddress = new DealAddress();
                    $dealAddress->deal_id = $model->id;
                    $dealAddress->address_id = $address_val;
                    $dealAddress->save();
                }
            }
            if(isset($deal_connect['product_id'])){
                foreach ($deal_connect['product_id'] as $key => $product){
                    if($deal_connect['product_id'][$key]) {
                        $productInfo = Product::findOne($deal_connect['product_id'][$key]);
                        $dealConect =  DealConect::find()->where(['id'=>$key])->one();
                        $dealConect->product_id = $deal_connect['product_id'][$key];
                        $dealConect->edit_date = $deal_connect['edit_date'];
                        $dealConect->installer_id = $deal_connect['installer_id'];
                        $dealConect->count = $deal_connect['count'][$key];
                        $dealConect->mac_address = $deal_connect['mac_address'][$key];
                        $dealConect->ip_address = $deal_connect['ip_address'][$key];
                        $dealConect->location = $deal_connect['location'][$key];
                        $dealConect->area = $deal_connect['area'][$key];
                        $dealConect->product_price = $productInfo->base_amount;
                        $dealConect->product_unit_id = $productInfo->unit_id;
                        $dealConect->basis = $deal_connect['basis'][$key];
                        $dealConect->save();
                    }
                }
            }
            if(isset($new_connect['product_id'])){
                foreach ($new_connect['product_id'] as $key => $product){
                    if($new_connect['product_id'][$key]) {
                        $productInfo = Product::findOne($new_connect['product_id'][$key]);
                        $newConnect = new DealConect();
                        $newConnect->deal_id = $model->id;
                        $newConnect->product_id = $new_connect['product_id'][$key];
                        $newConnect->edit_date = $new_connect['edit_date'];
                        $newConnect->installer_id = $new_connect['installer_id'];
                        $newConnect->eq_type = $new_connect['eq_type'][$key];
                        $newConnect->count = $new_connect['count'][$key];
                        $newConnect->mac_address = $new_connect['mac_address'][$key];
                        $newConnect->ip_address = $new_connect['ip_address'][$key];
                        $newConnect->location = $new_connect['location'][$key];
                        $newConnect->area = $new_connect['area'][$key];
                        $newConnect->product_price = $productInfo->base_amount;
                        $newConnect->product_unit_id = $productInfo->unit_id;
                        $newConnect->basis = $new_connect['basis'][$key];
                        $newConnect->save();
                    }
                }
            }
            if(!empty($post['Fields'])) {
                foreach ($post['Fields'] as $field => $value) {
                    $Cfield = CrmFieldValue::find()->where(['column_id' => $id, 'field_id' => $field])->one();
                    if ($Cfield) {
                        $Cfield->value = $value;
                        $Cfield->save();
                    } else {
                        $Cfield = new CrmFieldValue();
                        $Cfield->field_id = $field;
                        $Cfield->value = $value;
                        $Cfield->column_id = $model->id;
                        $Cfield->save();
                    }
                }
            }
            if (!empty($_FILES)) {

                $uploadTmp = $_FILES['file']['tmp_name'];
                $uploadType = $_FILES['file']['name'];
                if (!is_dir('deals')) {
                    mkdir('deals', 0777, true);
                }
                $path = 'deals/';
                foreach($uploadType as $key => $val){
                    $ext = pathinfo($val, PATHINFO_EXTENSION);
                    $name = microtime() . '.' . $ext;
                    $name = str_replace(' ', '', $name);
                    $uploadfile = $path . $name;
                    if(move_uploaded_file($uploadTmp[$key], $uploadfile)){
                        $image = new CrmDealFile();
                        $image->deal_id = $model->id;
                        $image->file = $name;
                        $image->save();
                    }
                }
            }

            return $this->redirect(['index']);
        }

        return $this->renderAjax('update', [
            'connects' => $connects,
            'field_values'=>$fields,
            'statuses' => $statuses,
            'vacation' => $vacation,
            'responsibles'=>$responsibles,
            'type' => $model->deal_type_id,
            'statuses_type' => $statuses_obj,
            'sections'=>$sections,
            'input_types'=>$input_types,
            'model' => $model,
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionAddVacation()
    {
        if(Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $vacation = new CrmDealVacation();
            $vacation->data_start = $post['start_date'];
            $vacation->data_end = $post['end_date'];
            $vacation->deal_id = $post['id'];
            return $vacation->save();
        }
    }
    public function actionCreateSection()
    {
        $post = Yii::$app->request->post();
        $section = new CrmSection();
        $section->menu_id = $this->menu_id;
        $section->name = $post['value'];
        $section->save();
        return json_encode(['result'=>$section->id]);
    }
    public function actionGetStagesByMenu()
    {
        if(Yii::$app->request->isAjax) {
            $type_id = intval(Yii::$app->request->post()['type_id']);
            $statuses = CrmStatus::find()->where(['menu_id' => $this->menu_id, 'type_id' => $type_id,'status_type'=>[0,1]])->all();
            $responsible = BillingQuery::staff()['Staff'];
            $responsibles = [];
            for ($i =0; $i<count($responsible); $i++){
                $responsibles[$responsible[$i]['id']] = $responsible[$i]['name'];
            }

            return $this->renderAjax('partials/right_part', [
                'responsibles' => $responsibles,
                'type' =>$type_id,
                'statuses_type' => $statuses,
            ]);
        }
    }
    public function actionGetProductsByType()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(Yii::$app->request->isAjax) {
            $type_id = intval(Yii::$app->request->post()['type_id']);
            return  Product::getProductListByType($type_id);
        }
    }
    public function actionAddField()
    {
        $post = Yii::$app->request->post();
        $field = new CrmCustomFields();
        $field->section_id = $post['section_id'];
        $field->field_type_id = $post['field_type_id'];
        $field->name = 'ccf_'.time();
        $field->label = $post['value'];
        $field->status = 1;
        $field->required = intval($post['required']);
        $field->save();
        if($field->field_type_id == 2 && $post['options'] != ''){
            $options = explode(',',$post['options']);
            $new_options = [];
            for ($i=0; $i<count($options); $i++){
                if($options[$i]){
                    $option = new CrmCustomList();
                    $option->custom_field_id = $field->id;
                    $option->value = $options[$i];
                    $option->save();
                    $new_options[$option->id] = $option->value;
                }
            }
            return json_encode(['options'=>$new_options,'name'=>$field->name,'id'=>$field->id]);
        } else {
            return json_encode(['name'=>$field->name,'id'=>$field->id]);
        }

    }
    public function actionUpdateField()
    {
        $post = Yii::$app->request->post();
        $field = CrmCustomFields::find()->where(['id'=>intval($post['field_id'])])->one();

        $field->label = $post['value'];
        $field->status = 1;
        $field->required = intval($post['required']);
        $field->save();
        if($field->field_type_id == 2 && $post['options'] != ''){
            $options = explode(',',$post['options']);
            $new_options = [];
            CrmCustomList::deleteAll(['custom_field_id'=>intval($post['field_id'])]);
            for ($i=0; $i<count($options); $i++){
                if($options[$i]){
                    $option = new CrmCustomList();
                    $option->custom_field_id = $field->id;
                    $option->value = $options[$i];
                    $option->save();
                    $new_options[$option->id] = $option->value;
                }
            }
            return json_encode(['options'=>$new_options,'name'=>$field->name,'id'=>$field->id]);
        } else {
            return json_encode(['name'=>$field->name,'id'=>$field->id]);
        }
        return true;

    }
    public function actionUpdateSection()
    {
        $post = Yii::$app->request->post();
        $section = CrmSection::findOne(['id'=>$post['id']]);
        $section->name = $post['value'];
        $section->save();
        return json_encode(['result'=>$section->id]);
    }
    public function actionDeleteSection()
    {
        $post = Yii::$app->request->post();
        return CrmSection::findOne(['id' =>intval($post['id'])])->delete();
    }
    public function actionDeleteField()
    {
        $post = Yii::$app->request->post();
        CrmCustomFields::findOne(['id' =>intval($post['id'])])->delete();
        if(intval($post['type']) == 2) {
            CrmCustomList::findOne(['custom_field_id' => intval($post['id'])])->delete();
        }
        return true;
    }
    public function actionDeleteDeals()
    {
        $post = Yii::$app->request->post();
        $ids = $post['ids'];
        if(!empty($ids)) {
            Deal::deleteAll(['id' => $ids]);
        }
        return true;
    }
    public function actionUpdateOrdering()
    {
        $post = Yii::$app->request->post();
        $ids = $post['ids'];
        for ($i=0; $i< count($ids); $i++){
            $model = CrmStatus::findOne(['id'=>$ids[$i]]);
            $model->ordering = $i+1;
            $model->save();
        }
        return true;
    }
    public function actionUpdateParams()
    {
        $post = Yii::$app->request->post();
        $id = $post['status_id'];

        $model = CrmStatus::findOne(['id'=>$id]);
        if(isset($post['color'])){
            $model->color = $post['color'];
        }
        if(isset($post['title'])){
            $model->name = $post['title'];
        }
        $res = $model->save();
        return $res;
    }
    public function actionAddStatus()
    {

        $post = Yii::$app->request->post();
        $ids = $post['ids'];
        $status_data = $post['status_data'];
        if(!empty($status_data['title'])) {
            $status = new CrmStatus();
            $status->ordering = $status_data['position'];
            $status->name = $status_data['title'];
            $status->menu_id = $this->menu_id;
            $status->color = '#eeeeee';
            $status->save();

            for ($i = 0; $i < count($ids); $i++) {
                if (strpos($ids[$i], 'new') == -1) {
                    $status_new = CrmStatus::findOne(['id' => $ids[$i]]);
                    $status_new->ordering = $i + 1;
                    $status_new->save();
                } else {
                    $status_new = CrmStatus::findOne(['id' => $status->id]);
                    $status_new->ordering = $i + 1;
                    $status_new->save();
                }
            }
        }
        return true;
    }
    public function actionAjaxCreate(){
        if (Yii::$app->request->post()) {
            $model = new Deal();
            $post = Yii::$app->request->post();
            $model->name = $post['title'];
            $model->status_id = $post['status_id'];
            $changeItems = Deal::find()->where(['>=','ordering',1])->andWhere(['status_id'=>$post['status_id']])->all();
            foreach ($changeItems as $changeItem => $itemVal){
                $itemVal->ordering = $itemVal->ordering + 1;
                $itemVal->save();
            }
            return $model->save();
        }
    }
    public function actionUpdateStatus()
    {

        $post = Yii::$app->request->post();
        $id = $post['id'];
        $status_id = $post['status_id'];
        $model = $this->findModel($id);
        $model->status_id = $status_id;
        $res = $model->save();
        $ids = $post['ids'];

        for ($i=0; $i< count($ids); $i++){
            $lead = Deal::findOne(['id'=>$ids[$i]]);
            $lead->ordering = $i+1;
            $lead->save();
        }
        return $res;
    }
    public function actionGetAddressList()
    {
        if(\Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $val = $post['value'];
            $type = $post['type_'];

            $user_info = ContactAdress::getContactAddressToString($type, $val);
            if(!empty($user_info)){
                return json_encode($user_info);
            }
        }
        return false;
    }
    public function actionGetServices()
    {
        if(\Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $val = $post['value'];

            if (!empty($post['type'])) {
                $type = $post['type'];
            } else {
                $type = null;
            }

            $services = [];
            if(!empty($val)){
                for ($i = 0; $i < count($val); $i++){

                    $user_info = ContactAdress::find()->where(['id'=>$val[$i]])->one();
                    if(!empty($user_info)) {
                        $city = $user_info->city_id;
                        $region = $user_info->region_id;
                        $services_ids = ServiceCountry::find()->select('service_id')->where(['city_id' => $city])->orWhere(['region_id' => $region, 'city_id' => ''])->asArray()->all();
                        foreach ($services_ids as $services_id => $val){
                            $services[] = intval($val["service_id"]);
                        }
                    }
                }
                if(!empty($services)){
                    return json_encode(Services::getServicesByIds($services));
                }
            }


        }
        return false;
    }
    public function actionGetTariffInfo()
    {
        if(Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post()['id'];
            $service_id = Yii::$app->request->post()['service_id'];
            $dataProvider =  Tariff::getTariffsByIds($post);
            $products = Product::find()->where(['eq_or_sup'=>1])->all();
            return $this->renderPartial('partials/tariff-item', ['tariffs' => $dataProvider,'service_id'=>$service_id, 'products'=>$products, 'isAjax' => true]);
        }
    }
    public function actionGetTariffInfoByShare()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(Yii::$app->request->isAjax) {
            $share_id = intval(Yii::$app->request->post()['id']);
            if($share_id) {
                return ShareTariffConfig::getTariffsByShareId($share_id);
            } else {
                return [];
            }
        }
    }
    public function actionGetServiceTariffs() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post()['id'];
            $data = [];
            if($post) {
                $data['prices'] = ServiceTariff::getServiceTariffWithPrice($post);
                $data['shares'] = Share::find()->where(['service_id'=>$post,'is_personal'=>0])->all();
                return $data;
            } else {
                return $data;
            }
        }
    }
    public function actionRemoveConnect()
    {
        $id = intval(Yii::$app->request->post()['id']);
        return DealConect::findOne($id)->delete();

    }
    /**
     * @return false|int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRemoveFile()
    {
        $id = intval(Yii::$app->request->post()['file_id']);
        $model = CrmDealFile::findOne($id);

        if(file_exists(Yii::$app->basePath.'/web/deals/'.$model->file)){
            $file = Yii::$app->basePath.'/web/deals/'.$model->file;
            unlink($file);
        }

        if ($model->delete()) {
            return Json::encode(['status' => true, 'title' => Yii::t('app', 'Успех'), 'message' => 'Файл успешно удален!']);
        } else {
            return Json::encode(['status' => false, 'title' => Yii::t('app', 'Ошибка'), 'message' => 'Пожалуйста, попробуйте еще раз!']);
        }

    }

    /**
     * Finds the Deal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Deal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Deal::findOne($id)) !== null) {
            return $model;
        }
//        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * @return string
     */
    public function setDealNumber()
    {
        //Get the highest "id" in the table + 1
        $max_id= Deal::find()->max('id');
        $document_number = $max_id ? $max_id+1 : 1;
        //set format of document number (XX00000001)
        return sprintf('%06d', $document_number);
    }

    /**
     * @param $configData
     * @param $deal
     * @return int
     */
    public function addShare($configData, $deal)
    {
                $share = new Share();
                $share->start_date = date('Y-m-d H:i:s', strtotime($deal->create_at));
                $share->end_date = date('Y-m-d H:i:s', strtotime($deal->date_finish));
                $share->is_personal = 1;
                $share->name = $deal->name;
                $share->service_id = $deal->service_id;
                $share->save();

                $configModel = new ShareTariffConfig();
                $configModel->share_id = $share->id;
                $configModel->tariff_id = $deal->tariff_id;
                $configModel->share_type = $configData['share_type'];

                if($configData['share_type'] == 0) {

                    if(intval($configData['is_internet'])) {
                        $configModel->internet_id = $configData['internet_id'];
                    } else {
                        $configModel->internet_id = null;
                    }
                    if(intval($configData['is_tv'])) {
                        $configModel->tv_packet_id = $configData['tv_packet_id'];
                    } else {
                        $configModel->tv_packet_id = null;
                    }
                    if(intval($configData['is_ip'])) {
                        $configModel->ip_address_count = $configData['ip_address_count'];
                    } else {
                        $configModel->ip_address_count = null;
                    }

                    $configModel->share_price_type = null;
                    $configModel->share_price_value = null;
                    $configModel->free_month = null;
                    $configModel->save();
                } else if($configData['share_type'] == 1){

                    $configModel->internet_id = null;
                    $configModel->tv_packet_id = null;
                    $configModel->ip_address_count = null;
                    $configModel->share_price_type = $configData['share_price_type'];
                    $configModel->share_price_value = $configData['share_price_value'];
                    $configModel->free_month = null;
                    $configModel->save();

                } else if($configData['share_type'] == 2){

                    $configModel->internet_id = null;
                    $configModel->tv_packet_id = null;
                    $configModel->ip_address_count = null;
                    $configModel->share_price_type = null;
                    $configModel->share_price_value = null;
                    $configModel->free_month = $configData['free_month'];
                    $configModel->save();

                }
        return $share->id;
    }
    public function actionPage()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $page = intval($post['page']);
            $sort = 'none';
            $column = '';

            if(isset($post['sort'])) {
                $sort = $post['sort'];
            }
            if(isset($post['column'])) {
                $column = $post['column'];
            }
            if(isset($post['dataSearch'])) {
                $dataSearch = $post['dataSearch'];
            } else {
                $dataSearch = '';
            }
            $searchModel = new DealSearch();

            // new example for table
            $dataProvider = $searchModel->search_new('/crm/deal', $page, $sort, $column, $dataSearch);
            return Json::encode($dataProvider);
        }
    }
    /**
     * @return array
     * @throws \yii\db\Exception
     */
    public function actionUpdateTable() {
        if(Yii::$app->request->isAjax) {
            $model = TableSettings::find()->where(['user_id'=>Yii::$app->user->id,'page'=>'/crm/deal'])->one();
            if(!empty($model)){
                if(isset($_POST['data']['str'])) {
                    $model->column_order = $_POST['data']['str'];
                }
                if(isset($_POST['data']['str_status'])) {
                    $model->column_status = $_POST['data']['str_status'];
                }
                if(isset($_POST['data']['count_show'])) {
                    $model->count_show = $_POST['data']['count_show'];
                }
                if(isset($_POST['data']['pin'])) {
                    $model->pined = $_POST['data']['pin'];
                }
                return $model->save();
            } else {
                $model = new TableSettings();
                $model->page = '/crm/deal';
                if(isset($_POST['data']['str'])) {
                    $model->column_order = $_POST['data']['str'];
                }
                if(isset($_POST['data']['count_show'])) {
                    $model->count_show = $_POST['data']['count_show'];
                }
                if(isset($_POST['data']['str_status'])) {
                    $model->column_status = $_POST['data']['str_status'];
                }
                if(isset($_POST['data']['pin'])) {
                    $model->pined = $_POST['data']['pin'];
                }
                $model->user_id = Yii::$app->user->id;
                return  $model->save();
            }
        }
    }
    /**
     * @return array
     * @throws \yii\db\Exception
     */
    public function actionUpdateSearch() {
        if(Yii::$app->request->isAjax) {

            $post = Yii::$app->request->post();
            $active = intval($post['data']['active']);
            $str = $post['data']['str_search'];
            $page = $post['data']['page'];

            if($active == 1) {
                $model = TableSettings::find()->where(['user_id'=>Yii::$app->user->id,'page'=>'/crm/deal'])->one();
                if(!empty($model)){
                    $model->column_search = $str;
                    return $model->save();

                } else {
                    $model = new TableSettings();
                    $model->column_search = $str;
                    return $model->save();
                }
            } else {
                if($active != -1) {
                    $model = TableSearch::find()->where(['id' => $active])->one();
                    $model->page = $page;
                    $model->column_search = $str;
                    return $model->save();
                } else {
                    $model = new TableSearch();
                    $model->page = $page;
                    $model->name = $post['data']['name'];
                    $model->user_id = Yii::$app->user->id;
                    $model->column_search = $str;
                    return $model->save();
                }
            }
        }
    }
}
