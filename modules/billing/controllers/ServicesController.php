<?php

namespace app\modules\billing\controllers;

use app\models\query\BaseQuery;
use app\modules\billing\models\SearchSettings;
use app\modules\billing\models\ServiceCountry;
use app\modules\billing\models\TableSettings;
use app\modules\billing\models\TariffSearch;
use Yii;
use app\modules\billing\models\Services;
use app\modules\billing\models\ServiceTariff;
use app\modules\billing\models\ServicesSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ServicesController implements the CRUD actions for Services model.
 */
class ServicesController extends Controller
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
     * Lists all Services models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServicesSearch();
        $dataProvider = $searchModel->search_new();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Services model.
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
     * Creates a new Services model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Services();

        $post = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (!empty($post['Tariff'])) {
                $tarifs = $post['Tariff'];

              foreach ($tarifs['total_price'] as $tariff => $val){
                  $service_tariff = new ServiceTariff();
                  $service_tariff->service_id = $model->id;
                  $service_tariff->tariff_id = $tariff;
                  $service_tariff->actual_price_type = $tarifs['actual_price_type'][$tariff];
                  $service_tariff->actual_price = $tarifs['actual_price'][$tariff];
                  $service_tariff->total_price = $tarifs['total_price'][$tariff];
                  $service_tariff->product_id = $tarifs['product_id'][$tariff];
                  $service_tariff->save();
              }
            }


            if (!empty($post['Services']['country_id'])) {
                $locations = new ServiceCountry();
                $locations->service_id = $model->id;
                $locations->country_id = $post['Services']['country_id'];
                $locations->region_id = !empty($post['Services']['region_id'])? $post['Services']['region_id'] : null;
                $locations->city_id = !empty($post['Services']['city_id'])? $post['Services']['city_id'] : null;
                $locations->save();
            }

            return $this->redirect(['index']);
        }

        return $this->renderAjax('create', [
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

    public function actionGetCitiesByRegion() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $post = Yii::$app->request->post();
        if (!empty($post['id'])) {
            return BaseQuery::renderCities($post['id']);
        }
    }

    /**
     * @return array
     */
    public function actionGetServiceTariffs() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post()['id'];
            if($post) {
                return ServiceTariff::getServiceTariff($post);
            } else {
                return [];
            }
        }
    }

    /**
     * Updates an existing Services model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax) {
            $clients = $model->getClients();
            return $this->renderAjax('update', [
                'model' => $model,
                'clients' => $clients,
            ]);
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $post = Yii::$app->request->post();
                if (!empty($post['Services']['country_id'])) {
                    $locations = ServiceCountry::findOne(['service_id'=>$id]);
                    $locations->country_id = $post['Services']['country_id'];
                    $locations->region_id = !empty($post['Services']['region_id'])? $post['Services']['region_id'] : null;
                    $locations->city_id = !empty($post['Services']['city_id'])? $post['Services']['city_id'] : null;
                    $locations->save();
                }
                return $this->redirect(['index']);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Services model.
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
     * @return array|string
     */
    public function actionSwitchView() {

        $searchModel = new ServicesSearch();
        $dataProvider = $searchModel->search_new();


        $post = Yii::$app->request->post();

        if (!empty($post['viewType'])) {

            $cookie = setcookie('_viewType', $post['viewType'], time() + (60 * 60 * 24 * 365));

            if ($cookie) {
                return $this->renderPartial('@billing/views/services/partials/_services_'.$post['viewType'], ['dataProvider' => $dataProvider, 'isAjax' => true]);
            } else {
                return false;
            }
        }
    }

    /**
     * @return bool
     */
    public function actionUpdateTable() {
        if(Yii::$app->request->isAjax) {
            $model = TableSettings::find()->where(['user_id' => Yii::$app->user->id, 'page' => '/services'])->one();

            if(!empty($model)) {
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
                $model->page = '/services';

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
     * @return bool
     */
    public function actionUpdateSearch() {
        if(Yii::$app->request->isAjax) {

            $post = Yii::$app->request->post();
            $active = intval($post['data']['active']);
            $str = $post['data']['str_search'];
            $page = $post['data']['page'];

            if($active == 1) {
                $model = TableSettings::find()->where(['user_id' => Yii::$app->user->id, 'page' => '/services'])->one();

                if(!empty($model)) {
                    $model->column_search = $str;
                    return $model->save();

                } else {
                    $model = new TableSettings();
                    $model->column_search = $str;
                    return $model->save();
                }
            } else {
                if($active != -1) {
                    $model = SearchSettings::find()->where(['id' => $active])->one();
                    $model->page = $page;
                    $model->column_search = $str;
                    return $model->save();
                } else {
                    $model = new SearchSettings();
                    $model->page = $page;
                    $model->name = $post['data']['name'];
                    $model->user_id = Yii::$app->user->id;
                    $model->column_search = $str;
                    return $model->save();
                }
            }
        }
    }

    /**
     * @return string
     */
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
            $searchModel = new ServicesSearch();

            // new example for table
            $dataProvider = $searchModel->search_new($page, $sort, $column, $dataSearch);
            return Json::encode($dataProvider);
        }
    }

    /**
     * Finds the Services model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Services the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Services::findOne($id)) !== null) {
            return $model;
        }

//        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
