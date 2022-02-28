<?php

namespace app\modules\crm\controllers;

use app\modules\billing\models\DealPaymentLog;
use Yii;
use app\modules\crm\models\CashRegisterReceipt;
use app\modules\crm\models\search\CashRegisterReceiptSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CashRegisterReceiptController implements the CRUD actions for CashRegisterReceipt model.
 */
class CashRegisterReceiptController extends Controller
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
     * Lists all CashRegisterReceipt models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CashRegisterReceiptSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CashRegisterReceipt model.
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
     * Creates a new CashRegisterReceipt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CashRegisterReceipt();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CashRegisterReceipt model.
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

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CashRegisterReceipt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionBulk() {
        // get $_POST
        $action = Yii::$app->request->post('action');  // action is the name of the dropdown list, get the selected bulk action
        $selection = (array)Yii::$app->request->post('selection'); // the selected ID from the grid view
        // sample output from the $selection:
        // array (size=6)
        //     0 => string '8' (length=1)
        //     1 => string '7' (length=1)
        //     2 => string '6' (length=1)
        //     3 => string '5' (length=1)
        //     4 => string '10' (length=2)
        //     5 => string '9' (length=1)

        // # the form submission is for the filter
        $filter = Yii::$app->request->post('CashRegisterReceiptSearch'); // TimesheetSearch is your filter
        if (isset($filter) && is_array($filter) && count($filter) > 0 && count($selection) == 0) {
            // check the pagesize_hidden param
            $pageSize = Yii::$app->request->post('pagesize_hidden');
            if ($pageSize === '') {
                $pageSize = 20; // my default page size
            }

            $param = '?pagesize='.$pageSize.'&';
            foreach ($filter as $key=>$value) {
                // ex: CashRegisterReceiptSearch[id]=1&CashRegisterReceiptSearch[work_date]=
                $param .= 'CashRegisterReceiptSearch[' . $key . ']' .'='. $value . '&';
            }

            // redirect with the query param
            return $this->redirect(['index'.$param]);
        }


        // # the form submission is for bulk action
        if(is_array($selection) && count($selection) > 0) {
            // your custom code here....
            $cashRegisterReceiptModel = CashRegisterReceipt::find()->where(['in', 'id', $selection])->all();

            if (!empty($cashRegisterReceiptModel)) {
                foreach ($cashRegisterReceiptModel as $item) {
                    $item->accepted_at = date('Y-m-d H:i:s');

                    if ($item->save()) {
                        $item->paymentLog->hdm = DealPaymentLog::HDM;
                        $item->paymentLog->save();
                    }
                }
            }
        }

        // redirect without the query param
        return $this->redirect(['index']);
    }

    /**
     * Finds the CashRegisterReceipt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CashRegisterReceipt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CashRegisterReceipt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
