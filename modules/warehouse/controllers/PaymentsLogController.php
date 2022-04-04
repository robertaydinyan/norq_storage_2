<?php

namespace app\modules\warehouse\controllers;

use app\components\Url;
use app\modules\warehouse\models\Favorite;
use app\modules\warehouse\models\TableRowsStatus;
use app\rbac\WarehouseRule;
use Yii;
use app\modules\warehouse\models\ProviderPayments;
use app\modules\warehouse\models\ProviderPaymentsSearch;
use app\modules\warehouse\models\SuppliersList;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QtyTypeController implements the CRUD actions for QtyType model.
 */
class PaymentsLogController extends Controller
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
     * Lists all QtyType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        TableRowsStatus::checkRows('ProviderPayments');
        $columns = TableRowsStatus::find()->where(['page_name' => 'ProviderPayments', 'userID' => Yii::$app->user->id, 'status' => 1])->orderBy('order')->all();
        $searchModel = new ProviderPaymentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'isFavorite' => $isFavorite,
            'columns' => $columns,
        ]);
    }

    /**
     * Displays a single QtyType model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        return $this->render('view', [
            'model' => $this->findModel($id),
            'isFavorite' => $isFavorite,
        ]);
    }

    /**
     * Creates a new QtyType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $model = new ProviderPayments();
        $partners = SuppliersList::find()->asArray()->all();
        $tableTreePartners = $this->buildTree($partners);

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            return $this->redirect(['index','isFavorite' => $isFavorite, 'lang' => \Yii::$app->language]);
        }


        return $this->render('create', [
            'model' => $model,
            'tableTreePartners'=>$tableTreePartners,
            'isFavorite' => $isFavorite,

        ]);
    }
    
    public function buildTree(array $elements, $parentId = null) {

        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] =  $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;

    }
    /**
     * Updates an existing QtyType model.
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
            return $this->redirect(['view', 'id' => $model->id, 'lang' => \Yii::$app->language]);
        }

        return $this->render('update', [
            'model' => $model,
            'isFavorite' => $isFavorite,
        ]);
    }

    /**
     * Deletes an existing QtyType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'lang' => \Yii::$app->language]);
    }

    /**
     * Finds the QtyType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return QtyType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProviderPayments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
