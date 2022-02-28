<?php

namespace app\modules\crm\controllers;

use app\components\Helper;
use app\models\query\BaseQuery;
use app\modules\crm\models\ContactPassport;
use app\modules\crm\models\ContactAdress;
use app\modules\crm\models\ContactCompany;
use app\modules\crm\models\ContactEmail;
use app\modules\crm\models\ContactPhone;
use app\modules\crm\models\CrmComments;
use app\modules\crm\models\CrmCustomFields;
use app\modules\crm\models\CrmCustomList;
use app\modules\crm\models\CrmFieldType;
use app\modules\crm\models\CrmFieldValue;
use app\modules\crm\models\CrmSection;
use app\modules\crm\models\query\CrmQuery;
use Yii;
use app\modules\crm\models\Contact;
use app\modules\crm\models\ContactSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends Controller
{
    private $menu_id = 3;
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
     * Lists all Contact models.
     * @return mixed
     */

    public function actionIndex()
    {
        $searchModel = new ContactSearch();
        $dataProvider = $searchModel->search_new();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contact model.
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
     * Creates a new Contact model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contact();

        $sections = CrmSection::find()->where(['menu_id' => $this->menu_id])->all();
        $input_types = CrmFieldType::find()->all();

        // Show popup
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'input_types' => $input_types,
                'model' => $model,
                'sections' => $sections,
            ]);
        } else {
            if (Yii::$app->request->post()) {
                $post = Yii::$app->request->post()['Contact'];

                $model->load(Yii::$app->request->post());
                $model->when_visible = date('Y-m-d H:i:s', strtotime($post['when_visible']));
                $model->valid_until = date('Y-m-d H:i:s', strtotime($post['valid_until']));
                $model->dob = date('Y-m-d H:i:s', strtotime(Yii::$app->request->post()['dob']));

                if($model->save()){

                    if (!empty($_FILES['Contact']['tmp_name']['passport_img'][0]) || !empty($_FILES['Contact']['tmp_name']['id_card'][0])) {

                        $dir = 'contact_passport';
                        Helper::createDirectory($dir);

                        if (!empty($_FILES['Company']['tmp_name']['passport_img'][0])) {
                            $type = 0;
                        }

                        if (!empty($_FILES['Company']['tmp_name']['id_card'][0])) {
                            $type = 1;
                        }

                        if (!empty($_FILES['Contact']['tmp_name']['passport_img'][0])) {
                            $uploadTmp = $_FILES['Contact']['tmp_name']['passport_img'];
                            $uploadType = $_FILES['Contact']['name']['passport_img'];
                            $type = 0;

                            foreach($uploadType as $key => $val){

                                $contactPassport = new ContactPassport();
                                $ext = pathinfo($val, PATHINFO_EXTENSION);
                                $name = microtime() . '.' . $ext;
                                $name = str_replace(' ', '', $name);
                                $uploadfile = $dir . '/' . $name;

                                if(move_uploaded_file($uploadTmp[$key], $uploadfile)){
                                    $contactPassport->contact_id = $model->id;
                                    $contactPassport->image = $name;
                                    $contactPassport->type = $type;
                                    $contactPassport->save();
                                }
                            }
                        }

                        if (!empty($_FILES['Contact']['tmp_name']['id_card'][0])) {
                            $uploadTmp = $_FILES['Contact']['tmp_name']['id_card'];
                            $uploadType = $_FILES['Contact']['name']['id_card'];
                            $type = 1;

                            foreach($uploadType as $key => $val){

                                $contactPassport = new ContactPassport();
                                $ext = pathinfo($val, PATHINFO_EXTENSION);
                                $name = microtime() . '.' . $ext;
                                $name = str_replace(' ', '', $name);
                                $uploadfile = $dir . '/' . $name;

                                if(move_uploaded_file($uploadTmp[$key], $uploadfile)){
                                    $contactPassport->contact_id = $model->id;
                                    $contactPassport->image = $name;
                                    $contactPassport->type = $type;
                                    $contactPassport->save();
                                }
                            }
                        }
                    }

                    // Address
                    if (!empty($post['country_id'][0])) {
                        foreach ($post['country_id'] as $key => $item) {

                            $address = new ContactAdress();
                            $address->contact_id = $model->id;
                            $address->country_id = !empty($post['country_id'][$key])? $post['country_id'][$key] : null;
                            $address->region_id = !empty($post['region_id'][$key])? $post['region_id'][$key] : null;
                            $address->city_id = !empty($post['city_id'][$key])? $post['city_id'][$key] : null;
                            $address->street = !empty($post['street'][$key])? $post['street'][$key] : null;
                            $address->house = !empty($post['house'][$key])? $post['house'][$key] : null;
                            $address->housing = !empty($post['housing'][$key])? $post['housing'][$key] : null;
                            $address->apartment = !empty($post['apartment'][$key])? $post['apartment'][$key] : null;
                            $address->save();
                        }
                    }

                    if(isset($post['phone'])){
                        foreach ($post['phone'] as $key => $phone){

                            if(trim($phone)) {
                                $contactPhone = new ContactPhone();
                                $contactPhone->contact_id = $model->id;
                                if (isset($post['is_mailing_phone'][$key])) {
                                    $contactPhone->is_mailing = 1;
                                }
                                if (isset($post['is_notification_phone'][$key])) {
                                    $contactPhone->is_notification = 1;
                                }

                                $contactPhone->phone = $phone;
                                $contactPhone->phone_type_id = $post['phoneType'][$key];
                                $contactPhone->save();
                            }
                        }
                    }
                    if(isset($post['email'])){
                        foreach ($post['email'] as $key => $email){
                            if(trim($email)) {
                                $contactEmail = new ContactEmail();
                                $contactEmail->contact_id = $model->id;
                                if (isset($post['is_mailing'][$key])) {
                                    $contactEmail->is_mailing = 1;
                                }
                                if (isset($post['is_notification'][$key])) {
                                    $contactEmail->is_notification = 1;
                                };
                                $contactEmail->name = $email;
                                $contactEmail->email_type_id = $post['emailType'][$key];
                                $contactEmail->save();
                            }
                        }
                    }

                    if(isset($post['company_id']) && !empty($post['company_id'])){
                        foreach ($post['company_id'] as $key => $company){
                            $contactCompany = new ContactCompany();
                            $contactCompany->contact_id = $model->id;
                            $contactCompany->company_id = $company;
                            $contactCompany->save();
                        }
                    }

                    if (!empty($post['Fields'])) {
                        foreach ($post['Fields'] as $field => $value) {
                            $Cfield = new CrmFieldValue();
                            $Cfield->field_id = $field;
                            $Cfield->value = $value;
                            $Cfield->column_id = $model->id;
                            $Cfield->save();
                        }
                    }

                    return $this->redirect(['index']);

                }

            }

            return $this->render('create', [
                'input_types' => $input_types,
                'model' => $model,
                'sections' => $sections
            ]);
        }
    }

    /**
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRemoveAddress() {

        if(Yii::$app->request->isAjax){
            $address_id = Yii::$app->request->post()['address_id'];
            if (!empty($address_id)) {
                $removeAddress = ContactAdress::findOne(['id' => $address_id])->delete();

                if ($removeAddress) {
                    return Json::encode(['status' => true, 'title' => Yii::t('app', 'Успех'), 'message' => 'Ваш адрес успешно удален!']);
                } else {
                    return Json::encode(['status' => false, 'title' => Yii::t('app', 'Ошибка'), 'message' => 'Пожалуйста, попробуйте еще раз!']);
                }
            }
        }
    }

    /**
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRemovePassportImage() {

        if(Yii::$app->request->isAjax){
            $file_id = Yii::$app->request->post()['file_id'];
            if (!empty($file_id)) {
                $removeImage = ContactPassport::findOne(['id' => $file_id]);

                if ($removeImage) {
                  $path = 'contact_passport/';
                  unlink($path.$removeImage['image']);

                  $removeImage->delete();

                  return Json::encode(['status' => true, 'title' => Yii::t('app', 'Успех'), 'message' => 'Файл успешно удален!']);
                } else {
                  return Json::encode(['status' => false, 'title' => Yii::t('app', 'Ошибка'), 'message' => 'Пожалуйста, попробуйте еще раз!']);
                }
            }
        }
    }

    /**
     * @return false|string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRemoveIdCard() {

        if (Yii::$app->request->isAjax) {
            $file_id = Yii::$app->request->post()['file_id'];
            if (!empty($file_id)) {
                $removeImage = ContactPassport::findOne(['id' => $file_id]);

                if ($removeImage) {
                    $path = 'contact_passport/';
                    unlink($path.$removeImage['image']);

                    $removeImage->delete();

                    return Json::encode(['status' => true, 'title' => Yii::t('app', 'Успех'), 'message' => 'Ваш адрес успешно удален!']);
                } else {
                    return Json::encode(['status' => false, 'title' => Yii::t('app', 'Ошибка'), 'message' => 'Пожалуйста, попробуйте еще раз!']);
                }
            }
        }

        return false;
    }

    /**
     * @return false|string
     */
    public function actionCreateSection()
    {
        $post = Yii::$app->request->post();
        $section = new CrmSection();
        $section->menu_id = $this->menu_id;
        $section->name = $post['value'];
        $section->save();
        return json_encode(['result'=>$section->id]);
    }

    /**
     * @return string
     */
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

    /**
     * @return string
     */
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
    }

    /**
     * @return string
     */
    public function actionUpdateSection()
    {
        $post = Yii::$app->request->post();
        $section = CrmSection::findOne(['id'=>$post['id']]);
        $section->name = $post['value'];
        $section->save();
        return json_encode(['result'=>$section->id]);
    }

    /**
     * @return false|int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteSection()
    {
        $post = Yii::$app->request->post();
        return CrmSection::findOne(['id' =>intval($post['id'])])->delete();
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteField()
    {
        $post = Yii::$app->request->post();
        CrmCustomFields::findOne(['id' =>intval($post['id'])])->delete();
        if(intval($post['type']) == 2) {
            CrmCustomList::findOne(['custom_field_id' => intval($post['id'])])->delete();
        }
        return true;
    }
    /**
     * Updates an existing Contact model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $sections = CrmSection::find()->where(['menu_id'=>$this->menu_id])->all();
        $input_types = CrmFieldType::find()->all();
        $field_values = CrmFieldValue::find()->where(['column_id'=>$id])->all();
        $fields = [];
        foreach ($field_values as $field=> $value ){
            $fields[$value->field_id] = $value->value;
        }

        if (Yii::$app->request->post()) {

            $post = Yii::$app->request->post()['Contact'];
            $model->load(Yii::$app->request->post());
            $model->when_visible = date('Y-m-d H:i:s', strtotime($post['when_visible']));
            $model->valid_until = date('Y-m-d H:i:s', strtotime($post['valid_until']));
            $model->dob = date('Y-m-d H:i:s', strtotime(Yii::$app->request->post()['dob']));
            if ($model->save()) {

                if (!empty($_FILES['Contact']['tmp_name']['passport_img'][0]) || !empty($_FILES['Contact']['tmp_name']['id_card'][0])) {

                    $dir = 'contact_passport';
                    Helper::createDirectory($dir);

                    if (!empty($_FILES['Contact']['tmp_name']['passport_img'][0])) {
                        $type = 0;
                    }

                    if (!empty($_FILES['Contact']['tmp_name']['id_card'][0])) {
                        $type = 1;
                    }

                    if (!empty($_FILES['Contact']['tmp_name']['passport_img'][0])) {
                        $uploadTmp = $_FILES['Contact']['tmp_name']['passport_img'];
                        $uploadType = $_FILES['Contact']['name']['passport_img'];
                        $type = 0;

                        foreach($uploadType as $key => $val){

                            $contactPassport = new ContactPassport();
                            $ext = pathinfo($val, PATHINFO_EXTENSION);
                            $name = microtime() . '.' . $ext;
                            $name = str_replace(' ', '', $name);
                            $uploadfile = $dir . '/' . $name;

                            if(move_uploaded_file($uploadTmp[$key], $uploadfile)){
                                $contactPassport->contact_id = $model->id;
                                $contactPassport->image = $name;
                                $contactPassport->type = $type;
                                $contactPassport->save();
                            }
                        }
                    }

                    if (!empty($_FILES['Contact']['tmp_name']['id_card'][0])) {
                        $uploadTmp = $_FILES['Contact']['tmp_name']['id_card'];
                        $uploadType = $_FILES['Contact']['name']['id_card'];
                        $type = 1;

                        foreach($uploadType as $key => $val){

                            $contactPassport = new ContactPassport();
                            $ext = pathinfo($val, PATHINFO_EXTENSION);
                            $name = microtime() . '.' . $ext;
                            $name = str_replace(' ', '', $name);
                            $uploadfile = $dir . '/' . $name;

                            if(move_uploaded_file($uploadTmp[$key], $uploadfile)){
                                $contactPassport->contact_id = $model->id;
                                $contactPassport->image = $name;
                                $contactPassport->type = $type;
                                $contactPassport->save();
                            }
                        }
                    }

                }

                // Address
                if (!empty($post['country_id'][0])) {
                    foreach ($post['country_id'] as $key => $item) {

                        if (!empty($post['id'])) {
                            $checkAddress = ContactAdress::find()->select('id')->where(['id' => $post['id'][$key]])->asArray()->one();

                            if (empty($checkAddress)) {
                                $address = new ContactAdress();
                            } else {
                                $address = ContactAdress::findOne($checkAddress['id']);
                            }
                        } else {
                            $address = new ContactAdress();
                        }

                        $address->contact_id = $model->id;
                        $address->country_id = !empty($post['country_id'][$key])? $post['country_id'][$key] : null;
                        $address->region_id = !empty($post['region_id'][$key])? $post['region_id'][$key] : null;
                        $address->city_id = !empty($post['city_id'][$key])? $post['city_id'][$key] : null;
                        $address->street = !empty($post['street'][$key])? $post['street'][$key] : null;
                        $address->house = !empty($post['house'][$key])? $post['house'][$key] : null;
                        $address->housing = !empty($post['housing'][$key])? $post['housing'][$key] : null;
                        $address->apartment = !empty($post['apartment'][$key])? $post['apartment'][$key] : null;
                        $address->save();
                    }
                }

                if(isset($post['phone'])){
                    foreach ($post['phone'] as $key => $phone){

                        if(trim($phone)) {
                            if (strpos($key, 'new') !== false) {

                                $contactPhone = new ContactPhone();
                                $contactPhone->contact_id = $model->id;
                                if (isset($post['is_mailing_phone'][$key])) {
                                    $contactPhone->is_mailing = 1;
                                }
                                if (isset($post['is_notification_phone'][$key])) {
                                    $contactPhone->is_notification = 1;
                                }

                                $contactPhone->phone = $phone;
                                $contactPhone->phone_type_id = $post['phoneType'][$key];
                                $contactPhone->save();
                            } else {

                                $contactPhone = ContactPhone::find()->where(['id' => $key])->one();
                                if (isset($post['is_mailing_phone'][$key])) {
                                    $contactPhone->is_mailing = 1;
                                } else {
                                    $contactPhone->is_mailing = 0;
                                }
                                if (isset($post['is_notification_phone'][$key])) {
                                    $contactPhone->is_notification = 1;
                                } else {
                                    $contactPhone->is_notification = 0;
                                }
                                $contactPhone->phone = $phone;
                                $contactPhone->phone_type_id = $post['phoneType'][$key];
                                $contactPhone->save();
                            }
                        }
                    }
                }
                if(isset($post['email'])){
                    foreach ($post['email'] as $key => $email){
                        if(trim($email)) {
                            if (strpos($key, 'new') !== false) {
                                $contactEmail = new ContactEmail();
                                $contactEmail->contact_id = $model->id;
                                if (isset($post['is_mailing'][$key])) {
                                    $contactEmail->is_mailing = 1;
                                }
                                if (isset($post['is_notification'][$key])) {
                                    $contactEmail->is_notification = 1;
                                }
                                $contactEmail->name = $email;
                                $contactEmail->email_type_id = $post['emailType'][$key];
                                $contactEmail->save();
                            } else {
                                $contactEmail = ContactEmail::find()->where(['id' => $key])->one();
                                if (isset($post['is_mailing'][$key])) {
                                    $contactEmail->is_mailing = 1;
                                } else {
                                    $contactEmail->is_mailing = 0;
                                }
                                if (isset($post['is_notification'][$key])) {
                                    $contactEmail->is_notification = 1;
                                } else {
                                    $contactEmail->is_notification = 0;
                                }
                                $contactEmail->name = $email;
                                $contactEmail->email_type_id = $post['emailType'][$key];
                                $contactEmail->save();
                            }
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
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('_form', [
            'field_values'=>$fields,
            'sections'=>$sections,
            'input_types'=>$input_types,
            'model' => $model,
        ]);
    }

    /**
     * @return array|string[]
     */
    public function actionGetRegionsByCountry() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $post = Yii::$app->request->post();
        if (!empty($post['id'])) {
            return BaseQuery::renderRegions($post['id']);
        }
    }

    /**
     * @return array|array[]
     */
    public function actionGetCitiesByRegion() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $post = Yii::$app->request->post();
        if (!empty($post['id'])) {
            return BaseQuery::renderCities($post['id']);
        }
    }

    /**
     * Deletes an existing Contact model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {

            ContactEmail::deleteAll(['contact_id' => $id]);
            ContactCompany::deleteAll(['contact_id' => $id]);
            ContactAdress::deleteAll(['contact_id' => $id]);
            ContactPhone::deleteAll(['contact_id' => $id]);
            $contactImage = ContactPassport::find()->where(['contact_id' => $id])->all();

            if (!empty($contactImage)) {

              foreach ($contactImage as $image) {
                unlink('contact_passport/'.$image->image);
              }

              ContactPassport::deleteAll(['contact_id' => $id]);
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * [actionRemoveContact description]
     * @return [type] [description]
     */
    public function actionRemoveContact()
    {
        $id = intval(Yii::$app->request->post()['id']);
        return ContactPhone::findOne($id)->delete();

    }

    /**
     * [actionRemoveEmail description]
     * @return [type] [description]
     */
    public function actionRemoveEmail()
    {
        $id = intval(Yii::$app->request->post()['id']);
        return ContactEmail::findOne($id)->delete();

    }

    /**
     * @return string|null
     */
    public function actionSwitchCrmPartial() {
        $request = Yii::$app->request;

        if ($request->isAjax) {
            $partial = $request->post('partial');
            $id = $request->get()[1]['id'];
            $model = [];

            if ($partial == 'product') {
                $model = CrmQuery::getProducts($id);
            }

            if ($partial == 'history') {
                $model = $this->findModel($id);
            }

            if ($partial == 'comment') {
                $model = CrmComments::getComment($id, false, 5);
            }

            return $this->renderPartial("partials/_{$partial}", [
                'model' => $model,
                'id' => $id
            ]);
        } else {
            return null;
        }
    }

    /**
     * @return string|null
     */
    public function actionSwitchLogType() {
        $request = Yii::$app->request;

        if ($request->isAjax) {
            $partial = $request->post('partial');
            $model = [];

            if ($partial == 'history') {
                $model = $this->findModel($request->post('model_id'));
            } else if ($partial == 'comment') {
                $model = CrmComments::getComment($request->post('model_id'));
            }

            return $this->renderPartial("partials/_{$partial}", [
                'model' => $model,
                'id' => $request->post('model_id')
            ]);
        } else {
            return null;
        }
    }

    /**
     * @return false|string
     */
    public function actionComment() {
        $request = Yii::$app->request;

        if ($request->isAjax) {
            $post = $request->post();

            $crmComment = new CrmComments();
            $crmComment->contact_id = $post['id'];
            $crmComment->crm_type = CrmComments::CONTACT_COMMENT;
            $crmComment->comment = $post['comment'];

            if ($crmComment->save()) {
                return $this->renderPartial('partials/_render_comment', [
                    'comment' => $crmComment->getCommentById($crmComment->id)
                ]);
            } else {
                return false;
            }
        }

        return false;
    }

    public function actionShowMoreComments()
    {
        $request = Yii::$app->request;

        if ($request->isAjax) {

            $model = CrmComments::getComment($request->post('id'), false, $request->post('limit'), $request->post('start'));
//            varDumper($model);die;

            return $this->renderPartial('partials/_render_load_more_comment', [
                'comment' => $model
            ]);
        }
    }

    /**
     * Finds the Contact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contact::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
