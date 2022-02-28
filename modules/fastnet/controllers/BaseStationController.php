<?php

namespace app\modules\fastnet\controllers;

use app\modules\billing\models\IpAddresses;
use app\modules\fastnet\models\BaseZones;
use app\modules\fastnet\models\BazeStationEquipments;
use app\traits\FindModelTrait;
use Carbon\Carbon;
use Yii;
use app\modules\fastnet\models\BaseStation;
use app\modules\fastnet\models\BaseStationSearch;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\warehouse\models\Warehouse;

/**
 * BaseStationController implements the CRUD actions for BaseStation model.
 */
class BaseStationController extends Controller
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
     * Lists all BaseStation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BaseStationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BaseStation model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel(BaseStation::class, $id),
        ]);
    }

    /**
     * Creates a new BaseStation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BaseStation();
        $equipments = new BazeStationEquipments();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $base_id = $model->id;
            if ($base_id && !empty($_POST['BaseStation']['zona_id'])) {
                $zoneIds = $_POST['BaseStation']['zona_id'];
                foreach ($zoneIds as $zones) {
                    $baseZone = new BaseZones();
                    $baseZone->base_id = $base_id;
                    $baseZone->zone_id = $zones;
                    $baseZone->save();
                }
            }
            if(!empty($model->ip) && !empty($model->ip_end)){
                $start_array = explode('.',$model->ip);
                $start_ip = end($start_array);
                $end_array = explode('.',$model->ip_end);
                $end_ip = end($end_array);

                if(intval($start_ip) && intval($end_ip)){
                    for($i = $start_ip; $i<= $end_ip; $i++){
                        $ip = new IpAddresses();
                        $ip->address = $start_array[0].'.'.$start_array[1].'.'.$start_array[2].'.'.$i;
                        $ip->status = 1;
                        $ip->price = 1000;
                        $ip->base_id = $model->id;
                        $ip->save();
                    }
                }
            }

            $equipments_list = Yii::$app->request->post()['BazeStationEquipments']['equipment_id'];
            if(!empty($equipments_list)){
                foreach ($equipments_list as $equipment => $val){
                    $equipment_zone = new BazeStationEquipments();
                    $equipment_zone->equipment_id = $val;
                    $equipment_zone->base_id = $model->id;
                    $equipment_zone->save();
                }
            }
            $whModel = new Warehouse();
            $whModel->name = $model->name;
            $whModel->base_station_id = $model->id;
            $whModel->created_at  = Carbon::now()->toDateTimeString();
            $whModel->type = 'virtual';
            $whModel->save();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'equipments' => $equipments,
        ]);
    }

    /**
     * Updates an existing BaseStation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel(BaseStation::class, $id);
        $equipments =  BazeStationEquipments::find()->where(['base_id'=>$model->id])->all();
        $isset_equipments = [];
        if(!empty($equipments)) {
            foreach ($equipments as $equipment => $val){
                array_push($isset_equipments,$val->equipment_id);
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $base_id = $model->id;
            if ($base_id && !empty($_POST['BaseStation']['zona_id'])) {
                BaseZones::deleteAll(['base_id' => $base_id]);
                $zoneIds = $_POST['BaseStation']['zona_id'];
                foreach ($zoneIds as $zones) {
                        $baseZone = new BaseZones();
                        $baseZone->base_id = $base_id;
                        $baseZone->zone_id = $zones;
                        $baseZone->save();
                }
            }
            if(isset(Yii::$app->request->post()['delete_olds']) && intval(Yii::$app->request->post()['delete_olds']) ==1){
                IpAddresses::deleteAll(['base_id'=>$model->id,'status'=>1]);
            }
            if(!empty($model->ip) && !empty($model->ip_end)){
                $start_array = explode('.',$model->ip);
                $start_ip = end($start_array);
                $end_array = explode('.',$model->ip_end);
                $end_ip = end($end_array);

                if(intval($start_ip) && intval($end_ip)){
                    for($i = $start_ip; $i<= $end_ip; $i++){
                        $ip = new IpAddresses();
                        $ip->address = $start_array[0].'.'.$start_array[1].'.'.$start_array[2].'.'.$i;
                        $ip->status = 1;
                        $ip->price = 1000;
                        $ip->base_id = $model->id;
                        $ip->save();
                    }
                }
            }
            BazeStationEquipments::deleteAll(['base_id'=>$model->id]);
            $equipments_list = Yii::$app->request->post()['BazeStationEquipments']['equipment_id'];
            if(!empty($equipments_list)){
                foreach ($equipments_list as $equipment => $val){
                    $equipment_zone = new BazeStationEquipments();
                    $equipment_zone->equipment_id = $val;
                    $equipment_zone->base_id = $model->id;
                    $equipment_zone->save();
                }
            }
            return $this->redirect(['index']);
        }
        $equipments_model = new BazeStationEquipments();
        return $this->render('update', [
            'model' => $model,
            'isset_equipments' => $isset_equipments,
            'equipments' => $equipments_model,
        ]);
    }

    /**
     * Deletes an existing BaseStation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel(BaseStation::class, $id)->delete();

        return $this->redirect(['index']);
    }
}
