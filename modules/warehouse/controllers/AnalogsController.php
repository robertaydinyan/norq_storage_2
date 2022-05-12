<?php

namespace app\modules\warehouse\controllers;

use app\modules\warehouse\models\TableRowsCount;
use app\modules\warehouse\models\TableRowsStatus;
use Yii;
use app\modules\warehouse\models\Analogs;
use app\modules\warehouse\models\AnalogsSearch;
use app\modules\warehouse\models\NomenclatureProduct;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * AnalogsController implements the CRUD actions for Analogs model.
 */
class AnalogsController extends Controller
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
     * Lists all Analogs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AnalogsSearch();

        TableRowsStatus::checkRows('Analogs');
        $columns = TableRowsStatus::find()->where(['page_name' => 'Analogs', 'userID' => Yii::$app->user->id, 'status' => 1])->orderBy('order')->all();
        $rows_count = TableRowsCount::find()->where(['page_name' => 'Analogs', 'userID' => Yii::$app->user->id])->one();
        $article = Yii::$app->request->get('article');
        $dataProvider = $searchModel->search($article, $rows_count);
        $dataProvider->pagination->pageSize = $rows_count['count'];


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columns' => $columns,
            'article' => $article
        ]);
    }

    /**
     * Displays a single Analogs model.
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
     * Creates a new Analogs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Analogs();
        $nomiclatures = ArrayHelper::map(NomenclatureProduct::find()->where(['isDeleted' => 0])->asArray()->all(),'id','name');
        if ($post = Yii::$app->request->post()) {
             
            if(!empty($post['Analogs']['analog_id'])){
                $post['Analogs']['analog_id'] = array_unique($post['Analogs']['analog_id']);
                for ($i=0; $i < count($post['Analogs']['analog_id']) ; $i++) { 
                    if($post['Analogs']['product_id'] != $post['Analogs']['analog_id'][$i]){
                        $analog = new Analogs();
                        $analog->product_id = $post['Analogs']['product_id'];
                        $analog->analog_id = $post['Analogs']['analog_id'][$i];
                        $analog->save(false);
                    }
                }
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'nomiclatures'=>$nomiclatures
        ]);
    }

    /**
     * Updates an existing Analogs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $nomiclatures = ArrayHelper::map(NomenclatureProduct::find()->where(['isDeleted' => 0])->asArray()->all(),'id','name');
        return $this->render('update', [
            'model' => $model,
            'nomiclatures'=>$nomiclatures
        ]);
    }

    /**
     * Deletes an existing Analogs model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $p = $this->findModel($id);
        $p->isDeleted = 1 - $p->isDeleted;
        $p->save(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Analogs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Analogs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Analogs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}