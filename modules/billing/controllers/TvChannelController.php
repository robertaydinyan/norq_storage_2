<?php

namespace app\modules\billing\controllers;

use app\modules\billing\models\ChannelIdBroadcastId;
use app\modules\billing\models\Internet;
use Yii;
use app\modules\billing\models\TvChannel;
use app\modules\billing\models\TvChannelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * TvChannelController implements the CRUD actions for TvChannel model.
 */
class TvChannelController extends Controller
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
     * Lists all TvChannel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new TvChannel();
        $searchModel = new TvChannelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TvChannel model.
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
     * Creates a new TvChannel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($config_url = false)
    {
        $model = new TvChannel();
        $post = Yii::$app->request->post();

        if (Yii::$app->request->isAjax) {

            return $this->renderAjax('_form', [
                'model' => $model, 'last_id' => TvChannel::getLastId(), 'config_url' => $config_url
            ]);
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
                $broadId = $post["broadcast_id"];
                $model_id = $model->id;
                if (isset($broadId) && !empty($broadId)) {
                    for ($i = 0; $i < count($broadId); $i++) {
                        $chanBrodIds = new ChannelIdBroadcastId();
                        $chanBrodIds->channel_id = $model_id;
                        $chanBrodIds->broadcast_id = $broadId[$i];
                        $chanBrodIds->save();
                    }
                }
                $model->logo_channel = UploadedFile::getInstance($model, 'logo_channel');
                $model->upload();
                $model->save(false);
                return $this->redirect(['configs/config-tv-channel']);
            }
        }
    }

    /**
     * Updates an existing TvChannel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $oldImage = Yii::$app->request->post('oldImage');
        $model = $this->findModel($id);
        $values = [];
        $image = TvChannel::find()->where(['id' => $id])->one();

        $post = Yii::$app->request->post();
        $tvChannelPacket = TvChannel::find()->where(['id' => $id])->all();
        foreach ($tvChannelPacket as $channels) {
            $res = ChannelIdBroadcastId::find()->where(['channel_id' => $channels['id']])->all();
            array_push($values, $res);
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model, 'last_id' => TvChannel::getLastId(), 'config_url' => true, 'values' => $values, 'image' => $image
            ]);
        } else {
            if (!empty($post)) {
                $oldImageModel = $model->logo_channel;

                if ($model->load($post) && $model->save()) {
                    if (
                        ['TvChannel']['name']['logo_channel']) {
                        if (file_exists('uploads/' . $oldImageModel) && !empty($oldImageModel)) {
                            unlink('uploads/' . $oldImageModel);
                        }
                        $model->logo_channel = UploadedFile::getInstance($model, 'logo_channel');
                        $model->upload();
                        $model->save(false);
                    } else {
                        if ($oldImage == ' ') {
                            if (file_exists('uploads/' . $oldImageModel) && !empty($oldImageModel)) {
                                unlink('uploads/' . $oldImageModel);
                            }
                        }
                        $model->logo_channel = $oldImage;
                        $model->save();
                    }
                    function deleteRelation($id)
                    {
                        $newModel = ChannelIdBroadcastId::find()->where(['channel_id' => $id])->all();
                        for ($i = 0; $i < count($newModel); $i++) {
                            $newModel[$i]->delete();
                        }
                    }

                    deleteRelation($id);
                    if (isset($post['broadcast_id']) && !empty($post['broadcast_id'])) {
                        foreach ($post['broadcast_id'] as $brId) {
                            $newRelation = new ChannelIdBroadcastId();
                            $newRelation->channel_id = $id;
                            $newRelation->broadcast_id = $brId;
                            $newRelation->save();
                        }
                    } else {
                        deleteRelation($id);
                    }
                    return $this->redirect(['configs/config-tv-channel']);
                }
            }
        }
    }

    /**
     * Deletes an existing TvChannel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['configs/config-tv-channel']);
    }

    /**
     * Finds the TvChannel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TvChannel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TvChannel::find()->where(['id' => $id])->multilingual()->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
