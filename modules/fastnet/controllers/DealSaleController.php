<?php

namespace app\modules\fastnet\controllers;

use app\modules\crm\models\Company;
use app\modules\crm\models\Contact;
use app\modules\fastnet\models\BaseStation;
use app\modules\fastnet\models\Deal;
use app\traits\FindModelTrait;
use Yii;
use app\modules\fastnet\models\DealSale;
use app\modules\fastnet\models\DealSaleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Request;

/**
 * DealSaleController implements the CRUD actions for DealSale model.
 */
class DealSaleController extends Controller
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
     * Lists all DealSale models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DealSaleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DealSale model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel(DealSale::class, $id),
        ]);
    }

    /**
     * Creates a new DealSale model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DealSale();
        $post = Yii::$app->request->post();
        if ($post) {
            if(!empty($post['Sale'])){
                $date = date("Y-m-01");
                $newdate = date("Y-m-01",strtotime ( '+1 month' , strtotime ( $date ) ));
                for ($i = 0; $i < count($post['Sale']); $i++ ){
                    $sale = new DealSale();
                    $sale->deal_id = $post['Sale'][$i];
                    $sale->price = $post['DealSale']['price'];
                    $sale->month = $newdate;
                    $sale->save();
                }
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DealSale model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel(DealSale::class, $id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DealSale model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel(DealSale::class, $id)->delete();

        return $this->redirect(['index']);
    }
}
