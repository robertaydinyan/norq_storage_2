<?php

namespace app\modules\crm\controllers;

use app\modules\crm\models\CompanyDocument;
use app\modules\crm\models\ContactAdress;
use app\modules\crm\models\ContactPhone;
use app\modules\fastnet\models\Streets;
use Yii;
use app\modules\crm\models\Company;
use app\modules\crm\models\CompanySearch;
use yii\base\BaseObject;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Request;
use yii\web\UploadedFile;

/**
 * FastCompanyController implements the CRUD actions for Company model.
 */
class FastCompanyController extends Controller
{
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
    public function actionCreate(Request $request)
    {
        $model = new Company();
        $address = new ContactAdress();
        $companyDocument = new CompanyDocument();
        $phone = new ContactPhone();

        if ($model->load($request->post())) {
            $C_C_address = $request->post('Company');
            $C_C_phone = $request->post('Company');
            $model->load($request->post());
            if ($model->save()) {
                $company_id = $model->id;
                $companyDocument->companyDocument = UploadedFile::getInstances($companyDocument, 'companyDocument');
                $companyDocument->upload($company_id);
                if (!empty(current($C_C_address['country_id']))) {
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
                        $addressForSave->company_id = $company_id;
                        $addressForSave->country_id = $C_C_address['country_id'][$k];
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
                        $addressForSave->save();
                    }
                }
                if (!empty(current($C_C_phone['phone']))) {
                    foreach ( $C_C_phone['phone'] as $key => $phone ) {
                        $contPhone = new ContactPhone();
                        $contPhone->company_id = $company_id;
                        $contPhone->phone = $phone;
                        $contPhone->save();
                    }
                }
                return $this->redirect(['index']);
            }

        }

        return $this->render('create', [
            'model' => $model,
            'address' => $address,
            'companyDocument' => $companyDocument,
            'phone' => $phone
        ]);
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(Request $request, $id)
    {
        $model = $this->findModel($id);
        $address = ContactAdress::find()->where(['company_id' => $id])->one();
        $companyDocument = new CompanyDocument();

        if ($model->load($request->post())) {

            $C_C_address = $request->post('Company');
            $C_C_phone = $request->post('Company');

            $companyDocument->companyDocument = UploadedFile::getInstances($companyDocument, 'companyDocument');
            $companyDocument->upload($id);

            if (!empty($C_C_address['country_id'])) {

                foreach ($C_C_address['country_id'] as $k => $add) {
                    if (!empty($C_C_address['country_id'][$k])) {

                        # If street not found, create
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

                        # Contact create or update
                        if (!empty($C_C_address['id'])) {
                            $checkAddress = ContactAdress::find()->select('id')->where(['id' => $C_C_address['id'][$k]])->asArray()->one();

                            if (empty($checkAddress)) {
                                $addressForSave = new ContactAdress();
                            } else {
                                $addressForSave = ContactAdress::findOne($checkAddress['id']);
                            }
                        } else {
                            $addressForSave = new ContactAdress();
                        }

                        $addressForSave->company_id = $id;
                        $addressForSave->country_id = $C_C_address['country_id'][$k];
                        if (isset($C_C_address['community_id'][$k])) {
                            $addressForSave->community_id = $C_C_address['community_id'][$k];
                        }

                        $addressForSave->region_id = $C_C_address['region_id'][$k];
                        $addressForSave->city_id = $C_C_address['city_id'][$k];
                        $addressForSave->street = $streetId;
                        $addressForSave->house = $C_C_address['house'][$k];
                        $addressForSave->housing = $C_C_address['housing'][$k];
                        $addressForSave->apartment = $C_C_address['apartment'][$k];
                        $addressForSave->save();
                    }

                }

            }

            if (!empty(current($C_C_phone['phone']))) {
                ContactPhone::deleteAll(['company_id' => $id]);
                foreach ($C_C_phone['phone'] as $phone) {
                    if (!empty($phone)) {
                        $contPhone = new ContactPhone();
                        $contPhone->company_id = $id;
                        $contPhone->phone = $phone;
                        $contPhone->save();
                    }
                }
            }

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'address' => $address,
            'companyDocument' => $companyDocument,
        ]);
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
        $model = $this->findModel($id);
        if ($model->delete()) {
            if ($model->contactAddress) {
                ContactAdress::deleteAll(['company_id' => $id]);
            }

            if ($model->requisiteFiles) {
                CompanyDocument::deleteAll(['company_id' => $id]);
            }

            if ($model->companyPhone) {
                ContactPhone::deleteAll(['company_id' => $id]);
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * @param Request $request
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRemoveDocument(Request $request) {

        if($request->isAjax){
            $file_id = $request->post()['file_id'];
            if (!empty($file_id)) {
                $removeImage = CompanyDocument::findOne(['id' => $file_id]);

                if ($removeImage) {
                    $path = 'company_document/';
                    unlink($path.$removeImage['image']);

                    $removeImage->delete();

                    return Json::encode(['status' => true, 'title' => Yii::t('app', 'Հաջող'), 'message' => 'Կազմակերպության փաստաթուղթը հաջողությամբ ջնջվել է:']);
                } else {
                    return Json::encode(['status' => false, 'title' => Yii::t('app', 'Սխալ'), 'message' => 'Խնդրում եմ կրկին փորձեք!']);
                }
            }
        }
    }

    public function actionRemoveAddress(Request $request) {

        if($request->isAjax){
            $address_id = $request->post()['address_id'];
            if (!empty($address_id)) {
                $removeAddress = ContactAdress::findOne(['id' => $address_id])->delete();

                if ($removeAddress) {
                    return Json::encode(['status' => true, 'title' => Yii::t('app', 'Հաջող'), 'message' => 'Կազմակերպության հասցեն հաջողությամբ ջնջվել է:']);
                } else {
                    return Json::encode(['status' => false, 'title' => Yii::t('app', 'Սխալ'), 'message' => 'Խնդրում եմ կրկին փորձեք!']);
                }
            }
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

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
