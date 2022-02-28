<?php

namespace app\modules\crm\controllers;

use app\modules\crm\models\DealType;
use Yii;
use app\modules\crm\models\CrmStatus;
use app\modules\crm\models\CrmStatusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CrmStatusController implements the CRUD actions for CrmStatus model.
 */
class CrmStatusController extends Controller
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
     * Lists all CrmStatus models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CrmStatusSearch();
        $dataProvider = $searchModel->search_new();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CrmStatus model.
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
     * Creates a new CrmStatus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate( $config_url = false)
    {
        $model = new DealType();
        $status_model = new CrmStatus();
        $post = Yii::$app->request->post();
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model,'status_model'=>$status_model, 'last_id' => CrmStatus::getLastId(), 'config_url' => $config_url
            ]);
        } else {
            $model->load(Yii::$app->request->post());
            $model->menu_id = $post['DealType']['menu_id'];
            $model->save();
            $statuses =  Yii::$app->request->post()['Status'];
            foreach ($statuses as $status => $status_val){
                foreach ($status_val['name'] as $key => $svalue){
                    if(trim($status_val['name'][$key])) {
                        $checkOrdering = CrmStatus::checkOrderID($model->id);
                        $new_status = new CrmStatus();
                        $new_status->name = $status_val['name'][$key];
                        $new_status->color = $status_val['color'][$key];
                        $new_status->menu_id = $model->menu_id;
                        $new_status->type_id = $model->id;
                        if (is_null($checkOrdering)) {
                            $new_status->ordering = 1;
                        } else {
                            $new_status->ordering = $checkOrdering + 1;
                        }
                        $new_status->status_type = $status;
                        $new_status->save();
                    }
                }

            }
            return $this->redirect(['/billing/configs/config-crm-status']);
        }
    }

    /**
     * Updates an existing CrmStatus model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = DealType::findOne($id);
        $all_statuses = CrmStatus::findAllStatuses($id);
        $status_model = new CrmStatus();
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model ,'last_id' => CrmStatus::getLastId(),'status_model'=>$status_model, 'all_statuses' => $all_statuses, 'config_url' => true
            ]);
        } else {
            $post = Yii::$app->request->post();
            $model->load(Yii::$app->request->post());
            $model->menu_id = $post['DealType']['menu_id'];
            $model->save();
            $statuses =  Yii::$app->request->post()['Status'];

            foreach ($statuses as $status => $status_val){

                foreach ($status_val['name'] as $key => $svalue){

                    if(trim($status_val['name'][$key])) {
                        $statuse_model = CrmStatus::find()->where(['type_id'=>$model->id,'id'=>$key])->one();
                        if($statuse_model){
                            $statuse_model->name = $status_val['name'][$key];
                            $statuse_model->color = $status_val['color'][$key];
                            $statuse_model->menu_id = $model->menu_id;
                            $statuse_model->save();
                        }
                    }
                }

            }
            return $this->redirect(['/billing/configs/config-crm-status']);

        }
    }

    /**
     * Deletes an existing CrmStatus model.
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
     * Finds the CrmStatus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CrmStatus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CrmStatus::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
