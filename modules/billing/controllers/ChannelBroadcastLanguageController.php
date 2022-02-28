<?php

namespace app\modules\billing\controllers;

use Yii;
use app\modules\billing\models\ChannelBroadcastLanguage;
use app\modules\billing\models\ChannelBroadcastLanguageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChannelBroadcastLanguageController implements the CRUD actions for ChannelBroadcastLanguage model.
 */
class ChannelBroadcastLanguageController extends Controller
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
     * Lists all ChannelBroadcastLanguage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChannelBroadcastLanguageSearch();
        $dataProvider = $searchModel->search_new();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ChannelBroadcastLanguage model.
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
     * Creates a new ChannelBroadcastLanguage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate( $config_url = false)
    {
        $model = new ChannelBroadcastLanguage();

        if(Yii::$app->request->isAjax) {

            return $this->renderAjax('_form', [
                'model' => $model, 'last_id' => ChannelBroadcastLanguage::getLastId(), 'config_url' => $config_url
            ]);
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['configs/config-channel-broadcast-language']);
            }
        }
    }

    /**
     * Updates an existing ChannelBroadcastLanguage model.
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
                'model' => $model ,'last_id' => ChannelBroadcastLanguage::getLastId(), 'config_url' =>true
            ]);
        } else {

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['configs/config-channel-broadcast-language']);
            }
        }
    }

    /**
     * Deletes an existing ChannelBroadcastLanguage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['configs/config-channel-broadcast-language']);
    }

    /**
     * Finds the ChannelBroadcastLanguage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ChannelBroadcastLanguage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ChannelBroadcastLanguage::findOne($id)) !== null) {
            return $model;
        }

//        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
