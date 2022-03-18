<?php

namespace app\modules\warehouse\controllers;

use app\components\Url;
use app\modules\warehouse\models\Favorite;
use Yii;
use app\modules\warehouse\models\PartnersList;
use app\modules\warehouse\models\SearchPartnersList;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartnersListController implements the CRUD actions for partners-list model.
 */
class PartnersListController extends Controller
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
     * Lists all partners-list models.
     * @return mixed
     */
    public function actionIndex()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;

        $searchModel = new SearchPartnersList();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'isFavorite' => $isFavorite,

        ]);
    }

    /**
     * Displays a single partners-list model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;

        return $this->render('view', [
            'model' => $this->findModel($id),
            'isFavorite' => $isFavorite,
            ]);
    }

    /**
     * Creates a new partners-list model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;

        $model = new PartnersList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'isFavorite' => $isFavorite,
        ]);
    }

    /**
     * Updates an existing partners-list model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'isFavorite' => $isFavorite,
        ]);
    }

    /**
     * Deletes an existing partners-list model.
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
     * Finds the partners-list model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PartnersList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PartnersList::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
