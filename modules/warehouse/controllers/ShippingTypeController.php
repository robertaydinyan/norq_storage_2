<?php

namespace app\modules\warehouse\controllers;

use Yii;
use app\modules\warehouse\models\ShippingType;
use app\modules\warehouse\models\SearchShippingType;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Notifications;
use app\models\User;

/**
 * ShippingTypeController implements the CRUD actions for ShippingType model.
 */
class ShippingTypeController extends Controller
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
     * Lists all ShippingType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchShippingType();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShippingType model.
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
     * Creates a new ShippingType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShippingType();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $admins = User::find()->where(['role'=>'admin'])->all();
            if(!empty($admins)){
                foreach ($admins as $key => $value) {
                   Notifications::setNotification($value->id,"Ստեղծվել է տեղափոխության տեսակ ".$model->name,'/warehouse/shipping-type');
                }
            }
            return $this->redirect(['index', 'lang' => \Yii::$app->language]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ShippingType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             $admins = User::find()->where(['role'=>'admin'])->all();
            if(!empty($admins)){
                foreach ($admins as $key => $value) {
                   Notifications::setNotification($value->id,"Փոփոխվել է տեղափոխության տեսակ ".$model->name,'/warehouse/shipping-type');
                }
            }
            return $this->redirect(['index', 'lang' => \Yii::$app->language]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ShippingType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $admins = User::find()->where(['role'=>'admin'])->all();
            if(!empty($admins)){
                foreach ($admins as $key => $value) {
                   Notifications::setNotification($value->id,"Ջնջվել է տեղափոխության տեսակ ".$id,'/warehouse/shipping-type');
                }
            }   
        return $this->redirect(['index', 'lang' => \Yii::$app->language]);
    }

    /**
     * Finds the ShippingType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShippingType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShippingType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
