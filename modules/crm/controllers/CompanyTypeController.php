<?php

namespace app\modules\crm\controllers;

use Yii;
use app\modules\crm\models\CompanyType;
use app\modules\crm\models\CompanyTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyTypeController implements the CRUD actions for CompanyType model.
 */
class CompanyTypeController extends Controller
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
     * Lists all CompanyType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanyTypeSearch();
        $dataProvider = $searchModel->search_new();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompanyType model.
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
     * Creates a new CompanyType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($config_url = false)
    {
        $model = new CompanyType();

        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model, 'last_id' => CompanyType::getLastId(), 'config_url' => $config_url
            ]);
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['/billing/configs/config-company-type']);
            }
        }
    }

    /**
     * Updates an existing CompanyType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model ,'last_id' => CompanyType::getLastId(), 'config_url' =>true
            ]);
        } else {

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['/billing/configs/config-company-type']);
            }
        }
    }

    /**
     * Deletes an existing CompanyType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/billing/configs/config-company-type']);
    }

    /**
     * Finds the CompanyType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompanyType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CompanyType::find()->where(['id' => $id])->multilingual()->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
