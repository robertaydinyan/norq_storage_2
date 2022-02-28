<?php

namespace app\modules\fastnet\controllers;

use app\models\DataBase;
use app\traits\FindModelTrait;
use Yii;
use app\modules\fastnet\models\Data;
use app\modules\fastnet\models\DataSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DataController implements the CRUD actions for Data model.
 */
class DataController extends Controller
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
     * Lists all Data models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Data model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel(Data::class, $id),
        ]);
    }

    /**
     * Creates a new Data model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Data();
        $base = new DataBase();
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->save()) {
            if(!empty($post['DataBase']['base_id'])){
                for ($i = 0; $i < count($post['DataBase']['base_id']); $i++){
                    $base_new = new DataBase();
                    $base_new->data_id = $model->id;
                    $base_new->base_id = $post['DataBase']['base_id'][$i];
                    $base_new->save();
                }
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'base' => $base,
        ]);
    }

    /**
     * Updates an existing Data model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel(Data::class, $id);
        $base_all = [];
        $base =  DataBase::find()->where(['data_id'=>$id])->all();
        $base_model =  new DataBase();
        if(!empty($base)){
            foreach ($base as $bs => $bs_val){
                array_push($base_all,$bs_val->base_id);
            }
        }
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->save()) {
            DataBase::deleteAll(['data_id'=>$model->id]);
            if(!empty($post['DataBase']['base_id'])){
                for ($i = 0; $i < count($post['DataBase']['base_id']); $i++){
                    $base_new = new DataBase();
                    $base_new->data_id = $model->id;
                    $base_new->base_id = $post['DataBase']['base_id'][$i];
                    $base_new->save();
                }
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
             'base_isset' => $base_all,
             'base' => $base_model
        ]);
    }

    /**
     * Deletes an existing Data model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel(Data::class, $id)->delete();

        return $this->redirect(['index']);
    }
}
