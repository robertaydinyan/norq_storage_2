<?php

namespace app\modules\billing\controllers;

use Yii;
use app\modules\billing\models\TvPacketChannel;
use app\modules\billing\models\TvPacketChannelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TvPacketChannelController implements the CRUD actions for TvPacketChannel model.
 */
class TvPacketChannelController extends Controller
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
     * Lists all TvPacketChannel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TvPacketChannelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TvPacketChannel model.
     * @param integer $packet_id
     * @param integer $channel_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($packet_id, $channel_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($packet_id, $channel_id),
        ]);
    }

    /**
     * Creates a new TvPacketChannel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TvPacketChannel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'packet_id' => $model->packet_id, 'channel_id' => $model->channel_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TvPacketChannel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $packet_id
     * @param integer $channel_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($packet_id, $channel_id)
    {
        $model = $this->findModel($packet_id, $channel_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'packet_id' => $model->packet_id, 'channel_id' => $model->channel_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TvPacketChannel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $packet_id
     * @param integer $channel_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($packet_id, $channel_id)
    {
        $this->findModel($packet_id, $channel_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TvPacketChannel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $packet_id
     * @param integer $channel_id
     * @return TvPacketChannel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($packet_id, $channel_id)
    {
        if (($model = TvPacketChannel::findOne(['packet_id' => $packet_id, 'channel_id' => $channel_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
