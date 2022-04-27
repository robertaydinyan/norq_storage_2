<?php

namespace app\modules\warehouse\controllers;

use app\components\Url;
use app\modules\warehouse\models\ComplectationProducts;
use app\modules\warehouse\models\Favorite;
use app\modules\warehouse\models\NomenclatureProduct;
use app\modules\warehouse\models\Product;
use app\modules\warehouse\models\ShippingProducts;
use app\modules\warehouse\models\ShippingRequest;
use app\modules\warehouse\models\TableRowsCount;
use app\modules\warehouse\models\TableRowsStatus;
use app\modules\warehouse\models\Warehouse;

use app\rbac\WarehouseRule;
use Yii;
use app\modules\warehouse\models\Complectation;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\User;
use app\models\Notifications;

/**
 * ComplectationController implements the CRUD actions for Complectation model.
 */
class ComplectationController extends Controller
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
     * Lists all Complectation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $dataProvider = new ActiveDataProvider([
            'query' => Complectation::find(),
        ]);
        TableRowsStatus::checkRows('Complectation');
        $columns = TableRowsStatus::find()->where(['page_name' => 'Complectation', 'userID' => Yii::$app->user->id, 'status' => 1])->orderBy('order')->all();
        $rows_count = TableRowsCount::find()->where(['page_name' => 'Complectation', 'userID' => Yii::$app->user->id])->one();
        $dataProvider->pagination->pageSize = $rows_count['count'];
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'isFavorite' => $isFavorite,
            'columns' => $columns,
        ]);
    }

    /**
     * Displays a single Complectation model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $id = intval($_GET['id']);
        $whProducts = ComplectationProducts::find()->where(['complectation_id'=>$id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'whProducts' => $whProducts,
            'isFavorite' => $isFavorite,
        ]);
    }

    /**
     * Creates a new Complectation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $model = new Complectation();
        $model_products = new ComplectationProducts();
        $dataWarehouses = ArrayHelper::map(Warehouse::find()->asArray()->all(), 'id', 'name');
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            $total_price = 0;
            if (isset($post['Product']['nomenclature_product_id']) && !empty($post['Product']['nomenclature_product_id'])) {
                foreach ($post['Product']['nomenclature_product_id'] as $key => $nProductId) {
                     if ($post['Product']['count'][$key]) {
                        $Origin_product = Product::findOne($nProductId);
                        $total_price += (intval($post['Product']['count'][$key])*intval($post['Product']['price'][$key]));
                    }
                }
            }
          
            $model->price = $total_price+$model->other_cost;
            $model->created_at = date('Y-m-d',strtotime($post['Complectation']['created_at']));
            $model->save(false);
            $admins = User::find()->where(['role'=>'admin'])->all();
            if(!empty($admins)){
                foreach ($admins as $key => $value) {
                   Notifications::setNotification($value->id,"Ստեղծվել է նոր կոմպլեկտացիա  ".$model->name,'/warehouse/complectation/view?id='.$model->id);
                }
            } 
            

            if (isset($post['Product']['nomenclature_product_id']) && !empty($post['Product']['nomenclature_product_id'])) {
                foreach ($post['Product']['nomenclature_product_id'] as $key => $nProductId) {
                    if ($post['Product']['count'][$key]) {
                        $ComplectationProduct = new ComplectationProducts();
                        $ComplectationProduct->n_product_count = $post['Product']['count'][$key];
                        $ComplectationProduct->price = $post['Product']['price'][$key];
                        $ComplectationProduct->numiclature_id = $nProductId;
                        $ComplectationProduct->complectation_id = $model->id;
                        $ComplectationProduct->save(false);
                    }
                }
            }
            return $this->redirect(['index','isFavorite' => $isFavorite]);
        }

        return $this->render('create', [
            'model' => $model,
            'model_products' => $model_products,
            'dataWarehouses' => $dataWarehouses,
            'index','isFavorite' => $isFavorite,
        ]);
    }

    /**
     * Updates an existing Complectation model.
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
            $admins = User::find()->where(['role'=>'admin'])->all();
            if(!empty($admins)){
                foreach ($admins as $key => $value) {
                   Notifications::setNotification($value->id,"Փոփոխվել է կոմպլեկտացիա  ".$model->name,'/warehouse/complectation/view?id='.$model->id);
                }
            } 
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'isFavorite' => $isFavorite,
        ]);
    }

    /**
     * Deletes an existing Complectation model.
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
     * Finds the Complectation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Complectation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Complectation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
