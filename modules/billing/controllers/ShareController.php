<?php

namespace app\modules\billing\controllers;

use app\modules\billing\models\SearchSettings;
use app\modules\billing\models\ShareTariffConfig;
use app\modules\billing\models\ShareUserConfig;
use app\modules\billing\models\TableSettings;
use app\modules\billing\models\Tariff;
use Yii;
use app\modules\billing\models\Share;
use app\modules\billing\models\ShareSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShareController implements the CRUD actions for Share model.
 */
class ShareController extends Controller
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
     * Lists all Share models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShareSearch();
        $dataProvider = $searchModel->search_new();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Share model.
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
     * Creates a new Share model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Share();

        if ($model->load(Yii::$app->request->post())) {

            $model->start_date = date('Y-m-d H:i:s', strtotime($model->start_date));
            $model->end_date = date('Y-m-d H:i:s', strtotime($model->end_date));
            $model->save();
            $post = Yii::$app->request->post();

            if (!empty($post['Share']['client_id'])) {
                foreach ($post['Share']['client_id'] as $client) {
                    $contact = new ShareUserConfig();
                    $contact->share_id = $model->id;
                    $contact->user_id = $client;
                    $contact->save();
                }
            }

            if (!empty($post['Tariff'])) {
                $configData = $post['Tariff'];
                foreach($configData['id'] as $config_key => $config_val){
                    $configModel = new ShareTariffConfig();
                    $configModel->share_id = $model->id;
                    $configModel->tariff_id = $config_val;
                    $configModel->share_type = $configData['share_type'][$config_key];

                    if($configData['share_type'][$config_key] == 0) {

                        if(intval($configData['is_internet'][$config_key])) {
                            $configModel->internet_id = $configData['internet_id'][$config_key];
                        } else {
                            $configModel->internet_id = null;
                        }
                        if(intval($configData['is_tv'][$config_key])) {
                            $configModel->tv_packet_id = $configData['tv_packet_id'][$config_key];
                        } else {
                            $configModel->tv_packet_id = null;
                        }
                        if(intval($configData['is_ip'][$config_key])) {
                            $configModel->ip_address_count = $configData['ip_address_count'][$config_key];
                        } else {
                            $configModel->ip_address_count = null;
                        }

                        $configModel->share_price_type = null;
                        $configModel->share_price_value = null;
                        $configModel->free_month = null;
                        $configModel->save();
                    } else if($configData['share_type'][$config_key] == 1){

                        $configModel->internet_id = null;
                        $configModel->tv_packet_id = null;
                        $configModel->ip_address_count = null;
                        $configModel->share_price_type = $configData['share_price_type'][$config_key];
                        $configModel->share_price_value = $configData['share_price_value'][$config_key];
                        $configModel->free_month = null;
                        $configModel->save();

                    } else if($configData['share_type'][$config_key] == 2){

                        $configModel->internet_id = null;
                        $configModel->tv_packet_id = null;
                        $configModel->ip_address_count = null;
                        $configModel->share_price_type = null;
                        $configModel->share_price_value = null;
                        $configModel->free_month = $configData['free_month'][$config_key];
                        $configModel->save();
                    }
                }
            }

            return $this->redirect(['index']);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'last_id' => Share::lastId()
        ]);
    }

    /**
     * Updates an existing Share model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model,
                'tariffs' => $model->tariffs
            ]);
        } else {
            if ($model->load(Yii::$app->request->post())) {
                $model->start_date = date('Y-m-d H:i:s', strtotime($model->start_date));
                $model->end_date = date('Y-m-d H:i:s', strtotime($model->end_date));
                $model->save();
                $post = Yii::$app->request->post();

                if (!empty($post['Share']['client_id'])) {
                    ShareUserConfig::deleteAll(['share_id' => $id]);

                    foreach ($post['Share']['client_id'] as $client) {
                        $contact = new ShareUserConfig();
                        $contact->share_id = $model->id;
                        $contact->user_id = $client;
                        $contact->save();
                    }
                }

                return $this->redirect(['index']);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Share model.
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
     * @return bool
     */
    public function actionUpdateTable() {
        if(Yii::$app->request->isAjax) {
            $model = TableSettings::find()->where(['user_id' => Yii::$app->user->id, 'page' => '/share'])->one();

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
                $model->page = '/share';

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
                $model = TableSettings::find()->where(['user_id' => Yii::$app->user->id, 'page' => '/share'])->one();

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
            $searchModel = new ShareSearch();

            // new example for table
            $dataProvider = $searchModel->search_new($page, $sort, $column, $dataSearch);
            return Json::encode($dataProvider);
        }
    }

    /**
     * Finds the Share model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Share the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Share::find()->where(['id' => $id])->multilingual()->one()) !== null) {
            return $model;
        }

//        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
