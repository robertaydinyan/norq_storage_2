<?php

namespace app\modules\warehouse\controllers;

use app\components\Url;
use app\modules\warehouse\models\Favorite;
use app\modules\warehouse\models\TableRowsCount;
use app\modules\warehouse\models\TableRowsStatus;
use app\rbac\WarehouseRule;
use Yii;
use app\modules\warehouse\models\WarehouseGroups;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WarehouseGroupsController implements the CRUD actions for WarehouseGroups model.
 */
class WarehouseGroupsController extends Controller
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
     * Lists all WarehouseGroups models.
     * @return mixed
     */
    public function actionIndex()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $dataProvider = new ActiveDataProvider([
            'query' => WarehouseGroups::find(),
        ]);
        TableRowsStatus::checkRows('WarehouseGroups');
        $columns = TableRowsStatus::find()->where(['page_name' => 'WarehouseGroups', 'userID' => Yii::$app->user->id, 'status' => 1])->orderBy('order')->all();
        $rows_count = TableRowsCount::find()->where(['page_name' => 'WarehouseGroups', 'userID' => Yii::$app->user->id])->one();
        $dataProvider->pagination->pageSize = $rows_count['count'];
        if ($rows_count && $rows_count->column_name) {
            $dataProvider->sort->defaultOrder = [$rows_count->column_name => ($rows_count->direction == "DESC" ? SORT_DESC : SORT_ASC)];
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'isFavorite' => $isFavorite,
            'columns' => $columns,

        ]);
    }

    /**
     * Creates a new WarehouseGroups model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $model = new WarehouseGroups();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'isFavorite' => $isFavorite]);
        }

        return $this->render('create', [
            'model' => $model,
            'isFavorite' => $isFavorite,
        ]);
    }

    /**
     * Updates an existing WarehouseGroups model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'isFavorite' => $isFavorite]);
        }

        return $this->render('update', [
            'model' => $model,
            'isFavorite' => $isFavorite,
        ]);
    }

    /**
     * Deletes an existing WarehouseGroups model.
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
     * Finds the WarehouseGroups model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WarehouseGroups the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WarehouseGroups::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
