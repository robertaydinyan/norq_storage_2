<?php

namespace app\modules\crm\controllers;

use app\components\Helper;
use app\modules\billing\models\Regions;
use app\modules\crm\models\ContactAdress;
use app\modules\crm\models\ContactPassport;
use app\modules\crm\models\ContactPhone;
use app\modules\fastnet\models\Streets;
use Yii;
use app\modules\crm\models\Contact;
use app\modules\crm\models\ContactSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * FastContactController implements the CRUD actions for Contact model.
 */
class FastContactController extends Controller
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
     * Lists all Contact models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContactSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        $address = new ContactAdress();
        $contactPassport = new ContactPassport();
        $phone = new ContactPhone();
        if (Yii::$app->request->post() ) {
            $post = Yii::$app->request->post();
            $C_C_address = $post['Contact'];
            $C_C_phone = $post['Contact'];
            $model->load($post);
            if ($model->save()) {
                $cont_id = $model->id;
                $contactPassport->contactPassport = UploadedFile::getInstances($contactPassport, 'contactPassport');
                $contactPassport->upload($cont_id);
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
                        $addressForSave->contact_id = $cont_id;
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
                        $contPhone->contact_id = $cont_id;
                        $contPhone->phone = $phone;
                        $contPhone->save();
                    }
                }
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'contactPassport' => $contactPassport,
            'address' => $address,
            'phone' => $phone
        ]);
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
        $address = ContactAdress::find()->where(['contact_id' => $id])->one();
        $contactPassport = new ContactPassport();
        $post = Yii::$app->request->post();
        $C_C_address = $post['Contact'];
        $C_C_phone = $post['Contact'];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $cont_id = $model->id;
            $contactPassport->contactPassport = UploadedFile::getInstances($contactPassport, 'contactPassport');
            $contactPassport->upload($cont_id);

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

                        $addressForSave->contact_id = $cont_id;
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
                ContactPhone::deleteAll(['contact_id' => $cont_id]);
                foreach ( $C_C_phone['phone'] as $key => $phone ) {
                    if (!empty($phone)) {
                        $contPhone = new ContactPhone();
                        $contPhone->contact_id = $cont_id;
                        $contPhone->phone = $phone;
                        $contPhone->save();
                    }
                }
            }

            return $this->redirect(['index']);
        }

        $model->dob = Helper::formatDate($model->dob, false);
        $model->when_visible = Helper::formatDate($model->when_visible, false);
        $model->valid_until = Helper::formatDate($model->valid_until, false);

        return $this->render('update', [
            'model' => $model,
            'address' => $address,
            'contactPassport' => $contactPassport
        ]);
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @return array|string[]
     */
    public function  actionGetRegionsByCountry () {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        $list = Regions::find()->all();
        $selected  = null;
        if ( count($list) > 0) {
            $selected = '';
            foreach ($list as $i => $account) {
                $out[] = ['id' => $account['id'], 'name' => $account['name']];
                if ($i == 0) {
                    $selected = $account['id'];
                }
            }
            // Shows how you can preselect a value
            return ['output' => $out, 'selected' => $selected];
        }

        return ['output' => '', 'selected' => ''];
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
                    return Json::encode(['status' => true, 'title' => Yii::t('app', 'Հաջող'), 'message' => Yii::t('app', 'Հասցեն հաջողությամբ ջնջվել է:')]);
                } else {
                    return Json::encode(['status' => false, 'title' => Yii::t('app', 'Սխալ'), 'message' => Yii::t('app', 'Խնդրում եմ կրկին փորձեք')]);
                }
            }
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

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
