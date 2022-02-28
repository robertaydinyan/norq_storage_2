<?php

namespace app\modules\billing\controllers;


use app\modules\billing\models\Internet;
use app\modules\billing\models\TvChannel;
use app\modules\billing\models\TvPacketChannel;
use Yii;
use app\modules\billing\models\TvPacket;
use app\modules\billing\models\TvPacketSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TvPacketController implements the CRUD actions for TvPacket model.
 */
class TvPacketController extends Controller
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
     * Lists all TvPacket models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TvPacket();
        $searchModel = new TvPacketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);


    }

    /**
     * Displays a single TvPacket model.
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
     * Creates a new TvPacket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($config_url = false)
    {


        $model = new TvPacket();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $tvPacket = Yii::$app->request->post()['TvPacket'];
            $tv_channel = Yii::$app->request->post()['tv_channel'];
            if (isset($tv_channel) && !empty($tv_channel)) {
                for ($i = 0; $i < count($tv_channel); $i++) {
                    $model->name = $tvPacket;
                    $model->save();
                    $newPacketChannel = new TvPacketChannel();
                    $newPacketChannel->packet_id = $model->id;
                    $newPacketChannel->channel_id = $tv_channel[$i];
                    $newPacketChannel->price = 1;
                    $newPacketChannel->save();
                }
            }
            return $this->redirect(['configs/config-tv-packet', 'id' => $model->id]);
        }
        return $this->renderAjax('create', [
            'model' => $model, 'last_id' => TvPacket::getLastId(), 'config_url' => $config_url
        ]);
    }

    /**
     * Updates an existing TvPacket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $values = [];
        $tvChannelPacket = TvPacketChannel::find()->where(['packet_id' => $id])->all();
        foreach ($tvChannelPacket as $channels) {
            $res = TvChannel::find()->where(['id' => $channels['channel_id']])->all();
            array_push($values, $res);
        }
        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model, 'last_id' => TvPacket::getLastId(), 'config_url' => true, 'values' => $values
            ]);
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                function deleteRelation($id)
                {
                    $newModel = TvPacketChannel::find()->where(['packet_id' => $id])->all();
                    for ($i = 0; $i < count($newModel); $i++) {
                        $newModel[$i]->delete();
                    }
                }

                deleteRelation($id);
                if (isset($post['tv_channel']) && !empty($post['tv_channel'])) {
                    foreach ($post['tv_channel'] as $brId) {
                        $newRelation = new TvPacketChannel();
                        $newRelation->packet_id = $id;
                        $newRelation->channel_id = $brId;
                        $newRelation->price = 1;
                        $newRelation->save();
                    }
                } else {
                    deleteRelation($id);
                }
                return $this->redirect(['configs/config-tv-packet']);
            }
        }
    }

    /**
     * Deletes an existing TvPacket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['configs/config-tv-packet']);
    }

    /**
     * Finds the TvPacket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TvPacket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TvPacket::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
