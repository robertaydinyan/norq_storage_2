<?php

namespace app\modules\crm\controllers;

use app\modules\crm\models\CashierOperator;
use app\traits\FindModelTrait;
use Yii;
use app\modules\crm\models\Cashier;
use app\modules\crm\models\CashierSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CashierController implements the CRUD actions for Cashier model.
 */
class CashierController extends Controller
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
     * Lists all Cashier models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CashierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cashier model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel(Cashier::class, $id),
        ]);
    }

    /**
     * Creates a new Cashier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cashier();
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $model->is_active = isset($post['Cashier']['is_active']) ? Cashier::ACTIVE : Cashier::INACTIVE;
                $model->blacklist = isset($post['Cashier']['blacklist']) ? Cashier::BLACKLIST_WHITE : Cashier::BLACKLIST_BLACK;
                $model->virtual = isset($post['Cashier']['virtual']) && !isset($post['Cashier']['blacklist']) ? Cashier::VIRTUAL : Cashier::NOT_VIRTUAL;
                if ($model->save()) {
                    $cashierRelation = new CashierOperator();
                    $cashierRelation->cashier_id = $model->id;
                    $cashierRelation->operator_id = $model->operator_id;

                    if ($cashierRelation->save()) {
                        $transaction->commit();
                        return $this->redirect(['index']);
                    } else {
                        $transaction->rollBack();
                    }
                }
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
                $transaction->rollBack();
            }
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing Cashier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel(Cashier::class, $id);
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $model->is_active = isset($post['Cashier']['is_active']) ? Cashier::ACTIVE : Cashier::INACTIVE;
                $model->blacklist = isset($post['Cashier']['blacklist']) ? Cashier::BLACKLIST_WHITE : Cashier::BLACKLIST_BLACK;
                $model->virtual = isset($post['Cashier']['virtual']) && !isset($post['Cashier']['blacklist']) ? Cashier::VIRTUAL : Cashier::NOT_VIRTUAL;

                if ($model->save()) {
                    CashierOperator::findOne(['cashier_id' => $model->id])->delete();
                    $cashierRelation = new CashierOperator();
                    $cashierRelation->cashier_id = $model->id;
                    $cashierRelation->operator_id = $model->operator_id;

                    if ($cashierRelation->save()) {
                        $transaction->commit();
                        return $this->redirect(['index']);
                    } else {
                        $transaction->rollBack();
                    }
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
                Yii::$app->session->setFlash('error', $e->getMessage());
                $transaction->rollBack();
            }
        }

        $model->operator_id = $model->operator->id;

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cashier model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        CashierOperator::findOne(['cashier_id' => $id])->delete();
        $this->findModel(Cashier::class, $id)->delete();

        return $this->redirect(['index']);
    }
}
