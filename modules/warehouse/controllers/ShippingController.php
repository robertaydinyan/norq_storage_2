<?php

namespace app\modules\warehouse\controllers;

use app\modules\warehouse\models\NomenclatureProduct;
use app\modules\warehouse\models\Product;
use app\modules\warehouse\models\ShippingProduct;
use app\modules\warehouse\models\ShippingProductSearch;
use app\modules\warehouse\models\ShippingRequest;
use app\modules\warehouse\models\ShippingRequestSearch;
use app\modules\warehouse\models\Warehouse;
use Carbon\Carbon;
use Yii;
use app\modules\warehouse\models\Shipping;
use app\modules\warehouse\models\ShippingSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShippingController implements the CRUD actions for Shipping model.
 */
class ShippingController extends Controller
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
     * Lists all Shipping models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShippingSearch();

        $userId = Yii::$app->user->identity->id;

        $userWarehouseId =  Warehouse::findOne(['user_id' => $userId]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $userWarehouseId->id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Shipping model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if ($this->findModel($id)->status == 'Ուղղարկված' || $this->findModel($id)->status == 'Հաստատված' ){
            $searchModel = new ShippingProductSearch();

            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        }
        if ($this->findModel($id)->status == 'Հարցված' || $this->findModel($id)->status == 'Հաստատված հարցում') {
            $searchModel = new ShippingRequestSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Shipping model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Shipping();

        $model->created_at  = Carbon::now()->toDateTimeString();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Shipping model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        //varDumper('kejfdk');die;
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Shipping model.
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
     * Finds the Shipping model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shipping the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Shipping::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionConfirmShipping($shippingId)
    {
        $toWarehouse = Shipping::findOne($shippingId)->supplier_warehouse_id;
        $shipping = Shipping::findOne($shippingId);
        $shipping->status = 'Հաստատված';
        $shipping->save();
        $shippingProducts = ShippingProduct::find()
        ->where(['shipping_id' => $shippingId])
        ->asArray()
        ->all();

        foreach ($shippingProducts as $shippingProduct) {
            if ($shippingProduct['count'] === null) {
                $product = Product::find()
                ->where(['id' => $shippingProduct['product_id']])
                ->one();
                $product->warehouse_id = $toWarehouse;
                $product->save(false);
            } else {

                $nProduct = Product::find()
                    ->where(['id' => $shippingProduct['product_id']])
                    ->one();
                if ($nProduct->count > $shippingProduct['count']) {
                    $newProduct = new Product();
                    $newProduct->price = $nProduct->price;
                    $newProduct->retail_price = $nProduct->retail_price;
                    $newProduct->supplier_name = $nProduct->supplier_name;
                    $newProduct->mac_address = $nProduct->mac_address;
                    $newProduct->comment = $nProduct->comment;
                    $newProduct->used = $nProduct->used;
                    $newProduct->created_at = $nProduct->created_at;
                    $newProduct->nomenclature_product_id = $nProduct->nomenclature_product_id;
                    $newProduct->warehouse_id = $toWarehouse;
                    $newProduct->count = $shippingProduct['count'];
                    $countProduct = $nProduct->count - $shippingProduct['count'];
                    $nProduct->count = $countProduct;

                    $newProduct->save(false);
                    $nProduct->save(false);

                    break;
                } else {
                    $nProduct->warehouse_id = $toWarehouse;
                    $nProduct->save(false);
                }

            }

        }

        $searchModel = new ShippingSearch();

        $userId = Yii::$app->user->identity->id;

        $userWarehouseId =  Warehouse::findOne(['user_id' => $userId]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $userWarehouseId->id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionEditShippingRequest($shippingId)
    {
        $model = new ShippingRequest();

        if ($model->load(Yii::$app->request->post())) {

            $post = Yii::$app->request->post();
            $shippingRequestIds = $post['ShippingRequest']['id'];
            $nProductsIds = $post['ShippingRequest']['nomenclature_product_id'];
            $counts = $post['ShippingRequest']['count'];
            for ($i = 0; $i < count($shippingRequestIds) ; $i++) {
                $shippingRequest = ShippingRequest::findOne($shippingRequestIds[$i]);
                $shippingRequest->nomenclature_product_id = $nProductsIds[$i];
                $shippingRequest->count = $counts[$i];
                $shippingRequest->save();

            }
            $shipping = Shipping::findOne($shippingId);
            $shipping->status = 'Հաստատված հարցում';
            $shipping->save();

            $searchModel = new ShippingSearch();

            $userId = Yii::$app->user->identity->id;

            $userWarehouseId =  Warehouse::findOne(['user_id' => $userId]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $userWarehouseId->id);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        $shippingProductsRequest = ShippingRequest::find()
            ->where(['shipping_id' => $shippingId])
            ->asArray()
            ->all();


        $nProducts = ArrayHelper::map(NomenclatureProduct::find()->asArray()->all(), 'id', 'name');
        return $this->render('_requestUpdate', [
            'shippingProductsRequest' => $shippingProductsRequest,
            'nProducts' => $nProducts,
            'shippingId' => $shippingId,
            'model' => $model
        ]);

    }
    public function actionConfirmShippingRequest($shippingId)
    {
        //varDumper($shippingId);die;
        $shipping = Shipping::findOne($shippingId);
        $shipping->status = 'Հաստատված հարցում';
        $shipping->save();

        $searchModel = new ShippingSearch();

        $userId = Yii::$app->user->identity->id;

        $userWarehouseId =  Warehouse::findOne(['user_id' => $userId]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $userWarehouseId->id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
       //varDumper($shippingProductsRequest);die;


    }
}
