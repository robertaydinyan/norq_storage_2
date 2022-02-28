<?php

namespace app\modules\billing\controllers;

use app\components\Helper;
use app\models\User;
use app\modules\billing\models\Internet;
use app\modules\billing\models\IpAddresses;
use app\modules\billing\models\SearchSettings;
use app\modules\billing\models\TableSettings;
use app\modules\billing\models\TvChannel;
use app\modules\billing\models\TvPacket;
use app\modules\billing\models\TvPacketChannel;
use app\modules\crm\models\Product;
use Yii;
use app\modules\billing\models\Tariff;
use app\modules\billing\models\TariffSearch;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TariffController implements the CRUD actions for Tariff model.
 */
class TariffController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => 'app\components\CAccessRule',
                ],
                'only' => ['index', 'create', 'view', 'update', 'delete', 'switch-view', 'get-internet-type', 'get-tariff-type-price', 'update-table', 'update-search', 'page'],
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => [
                            '?',
                        ],
                    ],
                    // Role for only not guests
                    [
                        'actions' => ['index', 'create', 'view', 'update', 'delete', 'switch-view', 'get-internet-type', 'get-tariff-type-price', 'update-table', 'update-search', 'page'],
                        'allow' => true,
                        'roles' => [
                            User::ROLE_ADMIN,
                            User::ROLE_MANAGER,
                            User::ROLE_OPERATOR,
                        ],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Tariff models.
     * @return mixed
     */
    public function actionIndex($type = null)
    {
        $model = new Tariff();
        $searchModel = new TariffSearch();
        $dataProvider = $searchModel->search_new(null, null, null, null, $type);

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => Helper::tariffCategory(),
        ]);
    }

    /**
     * Displays a single Tariff model.
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
     * Creates a new Tariff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tariff();
        $post = Yii::$app->request->post('Tariff');

        // Show popup
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        } else {

            // Load post and submit data
            if ($model->load(Yii::$app->request->post())) {

                if (isset($post['is_internet']) && $post['is_internet'] == 'on') {
                    $model->is_internet = 1;
                } else {
                    $model->is_internet = null;
                    $model->internet_type = null;
                    $model->internet_id = null;
                }

                if (isset($post['is_tv']) && $post['is_tv'] == 'on') {
                    $model->is_tv = 1;
                } else {
                    $model->is_tv = null;
                    $model->tv_packet_id = null;
                }

                if (isset($post['is_ip']) && $post['is_ip'] == 'on') {
                    $model->is_ip = 1;
                } else {
                    $model->is_ip = null;
                    $model->ip_count = null;
                }

                if (isset($post['is_active']) && $post['is_active'] == 'on') {
                    $model->is_active = 1;
                } else {
                    $model->is_active = 0;
                }

                // Disable validation for multilanguage columns
                if ($model->save(false)) {
                    return $this->redirect(['index']);
                }
            }
        }
    }

    /**
     * Updates an existing Tariff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post('Tariff');

        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model
            ]);
        } else {

            // Load post and submit data
            if ($model->load(Yii::$app->request->post())) {

                if (isset($post['is_internet']) && $post['is_internet'] == 'on') {
                    $model->is_internet = 1;
                } else {
                    $model->is_internet = null;
                    $model->internet_type = null;
                    $model->internet_id = null;
                }

                if (isset($post['is_tv']) && $post['is_tv'] == 'on') {
                    $model->is_tv = 1;
                } else {
                    $model->is_tv = null;
                    $model->tv_packet_id = null;
                }

                if (isset($post['is_ip']) && $post['is_ip'] == 'on') {
                    $model->is_ip = 1;
                } else {
                    $model->is_ip = null;
                    $model->ip_count = null;
                }

                if (isset($post['is_active']) && $post['is_active'] == 'on') {
                    $model->is_active = 1;
                } else {
                    $model->is_active = 0;
                }

                // Disable validation for multilanguage columns
                if ($model->save(false)) {
                    return $this->redirect(['index']);
                }
            }
        }
    }

    /**
     * Deletes an existing Tariff model.
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

        $post = Yii::$app->request->post();

        if (!empty($post['viewType'])) {

            $cookie = setcookie('_viewType', $post['viewType'], time() + (60 * 60 * 24 * 365), '/');

            if ($cookie) {

                $searchModel = new TariffSearch();

                if ($post['action'] == 'archived') {
                    $dataProvider = $searchModel->search_new(null, null, null, null, false);
                }

                if ($post['action'] == 'active') {
                    $dataProvider = $searchModel->search_new(null, null, null, null, true);
                }

                if ($post['action'] == 'index') {
                    $dataProvider = $searchModel->search_new();
                }

                return $this->renderPartial('@billing/views/tariff/partials/_tariff_'.$post['viewType'], ['dataProvider' => $dataProvider, 'isAjax' => true]);
            } else {
                return false;
            }
        }
    }

    /**
     * @return \string[][]
     */
    public function actionGetInternetType() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(Yii::$app->request->isAjax) {

            $post = Yii::$app->request->post('Tariff');

            return Tariff::getInternetByType($post['internet_type']);
        }
    }

    /**
     * @return \string[][]
     */
    public function actionGetTariffsByIds() {

        if(Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post()['ids'];
            $dataProvider =  Tariff::getTariffsByIds($post);
            $products = Product::find()->where(['eq_or_sup'=>1])->all();
            return $this->renderPartial('partials/tariff-service-item', ['tariffs' => $dataProvider, 'products'=>$products, 'isAjax' => true]);
        }
    }

    /**
     * @return \html[][]
     */
    public function actionGetTariffsHtmlByIds() {
        if(Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post()['ids'];
            $service_id = Yii::$app->request->post()['service_id'];
            $dataProvider = Tariff::getTariffsByIds($post);
            return $this->renderPartial('partials/tariff-share', ['tariffs' => $dataProvider,'service_id' => $service_id, 'isAjax' => true]);
        }
    }

    /**
     * @return array
     */
    public function actionGetTariffTypePrice() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(Yii::$app->request->isAjax) {

            $post = Yii::$app->request->post('Tariff');

            $internet_id = isset($post['is_internet']) && $post['is_internet'] == 'on' && !empty($post['internet_id']) ? $post['internet_id'] : null;
            $packet_id = isset($post['is_tv']) && $post['is_tv'] == 'on' ? $post['tv_packet_id'] : null;
            $ip_count = isset($post['is_ip']) && !empty($post['is_ip']) ? $post['ip_count'] : null;

            $actualPrice = Tariff::tariffCostPrice($internet_id, $packet_id, $ip_count);
            $cost_price = $actualPrice;
            if (isset($post['actual_price_type']) &&
                !empty($post['actual_price_type']) &&
                isset($post['actual_price']) &&
                !empty($post['actual_price'])) {

                if ($post['actual_price_type'] == 1) { // By Percent
                    $price = ($actualPrice / 100) * $post['actual_price'];
                    $actualPrice += $price;
                } else { // By price
                    $actualPrice += $post['actual_price'];
                }
            }

            $internet = [];
            if (isset($post['internet_type']) && !empty($post['internet_type'])) {
                $internet = Tariff::getInternetByType($post['internet_type']);
            }

            return [
                'actualPrice' => number_format($cost_price, 0, ',', ' '),
                'totalTariffPrice' => number_format($actualPrice, 0, ',', ' '),
                'internet' => $internet
            ];
        }
    }

    /**
     * @return bool
     */
    public function actionUpdateTable() {
        if(Yii::$app->request->isAjax) {
            $model = TableSettings::find()->where(['user_id' => Yii::$app->user->id, 'page' => '/tariff'])->one();

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
                $model->page = '/tariff';

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
                $model = TableSettings::find()->where(['user_id' => Yii::$app->user->id, 'page' => '/tariff'])->one();

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
            $searchModel = new TariffSearch();

            // new example for table
            $dataProvider = $searchModel->search_new($page, $sort, $column, $dataSearch);
            return Json::encode($dataProvider);
        }
    }

    /**
     * Finds the Tariff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tariff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tariff::find()->where(['id' => $id])->multilingual()->one()) !== null) {
            return $model;
        }

//        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
