<?php

namespace app\modules\billing\controllers;

use Yii;
use app\modules\billing\models\Internet;
use app\modules\billing\models\InternetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TvInternetController implements the CRUD actions for Internet model.
 */
class InternetController extends Controller
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
     * Lists all Internet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InternetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Internet model.
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
     * Creates a new Internet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($config_url = false)
    {
        $post = Yii::$app->request->post();
        $model = new Internet();
        if ($model->load(Yii::$app->request->post())) {
//            var_dump($_POST);die;
            if (isset($post['reset_speed_type']) && $post['reset_speed_type'] == 'on') {
                $model->reset_speed_type  = 1;
            } else {
                $model->reset_speed_type  = 0;
            }
            if (isset($post['sizeType']) && $post['sizeType'] == '0') {
                $model->size_empty_type  = 0;
            } else if (isset($post['sizeType']) && $post['sizeType'] == '1') {
                $model->size_empty_type  = 1;
            }
            if ($model->save()) {
                return $this->redirect(['configs/config-internet', 'id' => $model->id]);
            }

        }

        return $this->renderAjax('create', [
            'model' => $model, 'last_id' => Internet::getLastId(), 'config_url' =>$config_url
        ]);
    }

    /**
     * Updates an existing Internet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id  )
    {
        $model = $this->findModel($id);
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model' => $model ,'last_id' => Internet::getLastId(), 'config_url' =>true
            ]);
        } else {
            if ($model->load(Yii::$app->request->post()) ) {
                $model->size_empty_type = $_POST['sizeType'];
                if ($_POST['reset_speed_type'] == 'on') {
                    $model->reset_speed_type = 1;
                } else {
                    $model->reset_speed_type = 0;
                }
                $model->save();
                return $this->redirect(['configs/config-internet']);

            }
        }
    }

    /**
     * Deletes an existing Internet model.
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
     * Finds the Internet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Internet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Internet::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
