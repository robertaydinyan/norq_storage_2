<?php

namespace app\modules\crm\controllers;

use app\components\Helper;
use app\models\query\BaseQuery;
use app\modules\crm\models\CompanyDocument;
use app\modules\crm\models\ContactAdress;
use app\modules\crm\models\ContactCompany;
use app\modules\crm\models\ContactEmail;
use app\modules\crm\models\ContactPhone;
use app\modules\crm\models\CrmCustomFields;
use app\modules\crm\models\CrmCustomList;
use app\modules\crm\models\CrmFieldType;
use app\modules\crm\models\CrmFieldValue;
use app\modules\crm\models\CrmSection;
use app\modules\crm\models\query\CrmQuery;
use Yii;
use app\modules\crm\models\Company;
use app\modules\crm\models\CompanySearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
{
    private $menu_id = 2;
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
     * Lists all Company models.
     * @return mixed
     */

    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search_new();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Company model.
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
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Company();
        $sections = CrmSection::find()->where(['menu_id' => $this->menu_id])->all();
        $input_types = CrmFieldType::find()->all();

        // Show popup
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'input_types' => $input_types,
                'model' => $model,
                'sections' => $sections
            ]);
        } else {
            if (Yii::$app->request->post()) {
                $post = Yii::$app->request->post();
                $companyPost = Yii::$app->request->post()['Company'];

                $model->load(Yii::$app->request->post());
                $model->when_visible = date('Y-m-d H:i:s', strtotime($companyPost['when_visible']));
                $model->valid_until = date('Y-m-d H:i:s', strtotime($companyPost['valid_until']));

                if ($model->save()) {

                    if (!empty($_FILES['Company']['tmp_name']['passport_img'][0]) || !empty($_FILES['Company']['tmp_name']['id_card'][0])) {

                        $dir = 'company_documents';
                        Helper::createDirectory($dir);

                        if (!empty($_FILES['Company']['tmp_name']['passport_img'][0])) {
                            $type = 0;
                        }

                        if (!empty($_FILES['Company']['tmp_name']['id_card'][0])) {
                            $type = 1;
                        }

                        if (!empty($_FILES['Company']['tmp_name']['passport_img'][0])) {
                            $uploadTmp = $_FILES['Company']['tmp_name']['passport_img'];
                            $uploadType = $_FILES['Company']['name']['passport_img'];
                            $type = 0;

                            foreach($uploadType as $key => $val){

                                $ext = pathinfo($val, PATHINFO_EXTENSION);
                                $name = microtime() . '.' . $ext;
                                $name = str_replace(' ', '', $name);
                                $uploadfile = $dir . '/' . $name;

                                if(move_uploaded_file($uploadTmp[$key], $uploadfile)){
                                    $contactPassport = new CompanyDocument();
                                    $contactPassport->company_id = $model->id;
                                    $contactPassport->image = $name;
                                    $contactPassport->type = $type;
                                    $contactPassport->save();
                                }
                            }
                        }

                        if (!empty($_FILES['Company']['tmp_name']['id_card'][0])) {
                            $uploadTmp = $_FILES['Company']['tmp_name']['id_card'];
                            $uploadType = $_FILES['Company']['name']['id_card'];
                            $type = 1;

                            foreach($uploadType as $key => $val){

                                $ext = pathinfo($val, PATHINFO_EXTENSION);
                                $name = microtime() . '.' . $ext;
                                $name = str_replace(' ', '', $name);
                                $uploadfile = $dir . '/' . $name;

                                if(move_uploaded_file($uploadTmp[$key], $uploadfile)){
                                    $contactPassport = new CompanyDocument();
                                    $contactPassport->company_id = $model->id;
                                    $contactPassport->image = $name;
                                    $contactPassport->type = $type;
                                    $contactPassport->save();
                                }
                            }
                        }

                    }

                    // Address
                    if (!empty($companyPost['country_id'][0])) {
                        foreach ($companyPost['country_id'] as $key => $item) {

                            if (!empty($companyPost['id'])) {
                                $checkAddress = ContactAdress::find()->select('id')->where(['id' => $companyPost['id'][$key]])->asArray()->one();

                                if (empty($checkAddress)) {
                                    $address = new ContactAdress();
                                } else {
                                    $address = ContactAdress::findOne($checkAddress['id']);
                                }
                            } else {
                                $address = new ContactAdress();
                            }

                            $address->company_id = $model->id;
                            $address->country_id = !empty($companyPost['country_id'][$key])? $companyPost['country_id'][$key] : null;
                            $address->region_id = !empty($companyPost['region_id'][$key])? $companyPost['region_id'][$key] : null;
                            $address->city_id = !empty($companyPost['city_id'][$key])? $companyPost['city_id'][$key] : null;
                            $address->street = !empty($companyPost['street'][$key])? $companyPost['street'][$key] : null;
                            $address->house = !empty($companyPost['house'][$key])? $companyPost['house'][$key] : null;
                            $address->housing = !empty($companyPost['housing'][$key])? $companyPost['housing'][$key] : null;
                            $address->apartment = !empty($companyPost['apartment'][$key])? $companyPost['apartment'][$key] : null;
                            $address->save();
                        }
                    }

                    if (!empty($post['Company']['contact_id'])) {
                        foreach ($post['Company']['contact_id'] as $contacts) {
                            $contact = new ContactCompany();
                            $contact->contact_id = $contacts;
                            $contact->company_id = $model->id;
                            $contact->save();
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
     * @return false|string
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
     * @return bool|string
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
            return Json::encode(['options'=>$new_options,'name'=>$field->name,'id'=>$field->id]);
        } else {
            return Json::encode(['name'=>$field->name,'id'=>$field->id]);
        }
        return true;

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
        return Json::encode(['result'=>$section->id]);
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
     * [actionRemoveIdCard description]
     * @return [type] [description]
     */
      public function actionRemoveIdCard() {

          if(Yii::$app->request->isAjax){
              $file_id = Yii::$app->request->post()['file_id'];
              if (!empty($file_id)) {
                  $removeImage = CompanyDocument::findOne(['id' => $file_id]);

                  if ($removeImage) {
                    $path = 'company_documents/';
                    unlink($path.$removeImage['image']);

                    $removeImage->delete();

                    return Json::encode(['status' => true, 'title' => Yii::t('app', 'Успех'), 'message' => 'Ваш адрес успешно удален!']);
                  } else {
                    return Json::encode(['status' => false, 'title' => Yii::t('app', 'Ошибка'), 'message' => 'Пожалуйста, попробуйте еще раз!']);
                  }
              }
          }
      }

      /**
       * [actionRemovePassportImage description]
       * @return string
       */
        public function actionRemovePassportImage() {

            if(Yii::$app->request->isAjax){
                $file_id = Yii::$app->request->post()['file_id'];
                if (!empty($file_id)) {
                    $removeImage = CompanyDocument::findOne(['id' => $file_id]);

                    if ($removeImage) {
                      $path = 'company_documents/';
                      unlink($path.$removeImage['image']);

                      $removeImage->delete();

                      return Json::encode(['status' => true, 'title' => Yii::t('app', 'Успех'), 'message' => 'Ваш адрес успешно удален!']);
                    } else {
                      return Json::encode(['status' => false, 'title' => Yii::t('app', 'Ошибка'), 'message' => 'Пожалуйста, попробуйте еще раз!']);
                    }
                }
            }
        }

    /**
     * Updates an existing Lead model.
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

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'field_values'=>$fields,
                'sections'=>$sections,
                'input_types'=>$input_types,
                'model' => $model,
            ]);
        } else {

            $post = Yii::$app->request->post();
            $companyPost = Yii::$app->request->post()['Company'];
            $model->load(Yii::$app->request->post());
            if ($model->save()) {

                // Documents
                if (!empty($_FILES['Company']['tmp_name']['passport_img'][0]) || !empty($_FILES['Company']['tmp_name']['id_card'][0])) {

                    $dir = 'company_documents';
                    Helper::createDirectory($dir);

                    if (!empty($_FILES['Company']['tmp_name']['passport_img'][0])) {
                        $type = 0;
                    }

                    if (!empty($_FILES['Company']['tmp_name']['id_card'][0])) {
                        $type = 1;
                    }

                    if (!empty($_FILES['Company']['tmp_name']['passport_img'][0])) {
                        $uploadTmp = $_FILES['Company']['tmp_name']['passport_img'];
                        $uploadType = $_FILES['Company']['name']['passport_img'];
                        $type = 0;

                        foreach($uploadType as $key => $val){

                            $companyPassport = new CompanyDocument();
                            $ext = pathinfo($val, PATHINFO_EXTENSION);
                            $name = microtime() . '.' . $ext;
                            $name = str_replace(' ', '', $name);
                            $uploadfile = $dir . '/' . $name;

                            if(move_uploaded_file($uploadTmp[$key], $uploadfile)){
                                $companyPassport->company_id = $model->id;
                                $companyPassport->image = $name;
                                $companyPassport->type = $type;
                                $companyPassport->save();
                            }
                        }
                    }

                    if (!empty($_FILES['Company']['tmp_name']['id_card'][0])) {
                        $uploadTmp = $_FILES['Company']['tmp_name']['id_card'];
                        $uploadType = $_FILES['Company']['name']['id_card'];
                        $type = 1;

                        foreach($uploadType as $key => $val){

                            $companyPassport = new CompanyDocument();
                            $ext = pathinfo($val, PATHINFO_EXTENSION);
                            $name = microtime() . '.' . $ext;
                            $name = str_replace(' ', '', $name);
                            $uploadfile = $dir . '/' . $name;

                            if(move_uploaded_file($uploadTmp[$key], $uploadfile)){
                                $companyPassport->company_id = $model->id;
                                $companyPassport->image = $name;
                                $companyPassport->type = $type;
                                $companyPassport->save();
                            }
                        }
                    }

                }

                // Address
                if (!empty($companyPost['country_id'][0])) {
                    foreach ($companyPost['country_id'] as $key => $item) {

                        if (!empty($companyPost['id'])) {
                            $checkAddress = ContactAdress::find()->select('id')->where(['id' => $companyPost['id'][$key]])->asArray()->one();

                            if (empty($checkAddress)) {
                                $address = new ContactAdress();
                            } else {
                                $address = ContactAdress::findOne($checkAddress['id']);
                            }
                        } else {
                            $address = new ContactAdress();
                        }

                        $address->company_id = $model->id;
                        $address->country_id = !empty($companyPost['country_id'][$key])? $companyPost['country_id'][$key] : null;
                        $address->region_id = !empty($companyPost['region_id'][$key])? $companyPost['region_id'][$key] : null;
                        $address->city_id = !empty($companyPost['city_id'][$key])? $companyPost['city_id'][$key] : null;
                        $address->street = !empty($companyPost['street'][$key])? $companyPost['street'][$key] : null;
                        $address->house = !empty($companyPost['house'][$key])? $companyPost['house'][$key] : null;
                        $address->housing = !empty($companyPost['housing'][$key])? $companyPost['housing'][$key] : null;
                        $address->apartment = !empty($companyPost['apartment'][$key])? $companyPost['apartment'][$key] : null;
                        $address->save();
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



        return $this->renderAjax('update', [
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
     * Deletes an existing Company model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {

            ContactEmail::deleteAll(['company_id' => $id]);
            ContactCompany::deleteAll(['company_id' => $id]);
            ContactAdress::deleteAll(['company_id' => $id]);
            ContactPhone::deleteAll(['company_id' => $id]);
            CompanyDocument::deleteAll(['company_id' => $id]);

            // Delete directory with document images
            $dir = 'company_documents';
            Helper::deleteDirectoryWithContent($dir);
        }

        return $this->redirect(['index']);
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

            if ($partial == 'all') {
                $model = $this->findModel($id);
            }

            if ($partial == 'product') {
                $model = CrmQuery::getProducts($id, true);
            }

            return $this->renderPartial("partials/{$partial}", [
                'model' => $model
            ]);
        } else {
            return null;
        }
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
