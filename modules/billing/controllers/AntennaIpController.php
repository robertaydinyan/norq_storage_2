<?php

namespace app\modules\billing\controllers;

use app\modules\billing\models\AntennaIp;
use app\traits\FindModelTrait;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AntennaIpController extends Controller
{

    use FindModelTrait;

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
     * Creates a new IpAddresses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AntennaIp();

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model
            ]);
        } else  {
            if ($model->load(Yii::$app->request->post())) {
                if(!empty($model->ip_start) && !empty($model->ip_end)){
                    $base_station_id = Yii::$app->request->post('AntennaIp');

                    $start_array = explode('.',$model->ip_start);
                    $start_ip = end($start_array);
                    $end_array = explode('.',$model->ip_end);
                    $end_ip = end($end_array);

                    if (intval($start_ip) && intval($end_ip)) {
                        for ($i = $start_ip; $i <= $end_ip; $i++) {
                            $ip = new AntennaIp();
                            $ip->base_station_id = $base_station_id['base_station_id'];
                            $ip->ip_address = $start_array[0].'.'.$start_array[1].'.'.$start_array[2].'.'.$i;
                            $ip->save();
                        }
                    }
                }

                return $this->redirect(['/billing/configs/antenna-ip', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing IpAddresses model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel(AntennaIp::class, $id);

        if (Yii::$app->request->isAjax) {

            $model->ip_start = AntennaIp::find()->one()->ip_address;

            return $this->renderAjax('create', [
                'model' => $model
            ]);
        } else  {
            if ($model->load(Yii::$app->request->post())) {
                if(!empty($model->ip_start) && !empty($model->ip_end)){
                    $start_array = explode('.',$model->ip_start);
                    $start_ip = end($start_array);
                    $end_array = explode('.',$model->ip_end);
                    $end_ip = end($end_array);

                    if (intval($start_ip) && intval($end_ip)) {
                        for ($i = $start_ip; $i <= $end_ip; $i++) {
                            $ip = new AntennaIp();
                            $ip->ip_address = $start_array[0].'.'.$start_array[1].'.'.$start_array[2].'.'.$i;
                            $ip->save();
                        }
                    }
                }

                return $this->redirect(['/billing/configs/antenna-ip', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    public function actionUpdateIp($id)
    {
        $model = $this->findModel(AntennaIp::class, $id);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_ip_form', [
                'model' => $model
            ]);
        } else  {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['/billing/configs/antenna-ip', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model
            ]);
        }
    }
}