<?php

namespace app\modules\billing\controllers;

use Yii;
use app\modules\billing\models\ChannelCategory;
use app\modules\billing\models\ChannelCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChannelCategoryController implements the CRUD actions for ChannelCategory model.
 */
class ChannelCategoryController extends Controller
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
     * Lists all ChannelCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChannelCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ChannelCategory model.
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
     * Creates a new ChannelCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate( $config_url = false)
    {
        $model = new ChannelCategory();

        if(Yii::$app->request->isAjax) {

            return $this->renderAjax('_form', [
                'model' => $model, 'last_id' => ChannelCategory::getLastId(), 'config_url' => $config_url
            ]);
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['configs/config-channel-category']);
            }
        }
    }

    /**
     * Updates an existing ChannelCategory model.
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
                'model' => $model ,'last_id' => ChannelCategory::getLastId(), 'config_url' =>true
            ]);
        } else {

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['configs/config-channel-category']);
            }
        }
    }

    /**
     * Deletes an existing ChannelCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['configs/config-channel-category']);
    }

    /**
     * Finds the ChannelCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ChannelCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ChannelCategory::findOne($id)) !== null) {
            return $model;
        }

//        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
