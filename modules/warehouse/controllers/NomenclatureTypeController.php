<?php

namespace app\modules\warehouse\controllers;

use app\modules\warehouse\models\TableRowsCount;
use app\modules\warehouse\models\TableRowsStatus;
use Yii;
use app\modules\warehouse\models\NomenclatureType;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NomenclatureTypeController implements the CRUD actions for NomenclatureType model.
 */
class NomenclatureTypeController extends Controller
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
     * Lists all NomenclatureType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => NomenclatureType::find(),
        ]);
        TableRowsStatus::checkRows('NomenclatureType');
        $columns = TableRowsStatus::find()->where(['page_name' => 'NomenclatureType', 'userID' => Yii::$app->user->id, 'status' => 1])->orderBy('order')->all();
        $rows_count = TableRowsCount::find()->where(['page_name' => 'NomenclatureType', 'userID' => Yii::$app->user->id])->one();
        $dataProvider->pagination->pageSize = $rows_count['count'];
        if ($rows_count && $rows_count->column_name) {
            $dataProvider->sort->defaultOrder = [$rows_count->column_name => ($rows_count->direction == "DESC" ? SORT_DESC : SORT_ASC)];
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'columns' => $columns,
        ]);
    }

    /**
     * Displays a single NomenclatureType model.
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
     * Creates a new NomenclatureType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NomenclatureType();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing NomenclatureType model.
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
     * Deletes an existing NomenclatureType model.
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
     * Finds the NomenclatureType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NomenclatureType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NomenclatureType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
