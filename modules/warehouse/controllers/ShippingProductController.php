<?php

namespace app\modules\warehouse\controllers;

use app\components\Url;
use app\models\query\BaseQuery;
use app\models\User;
use app\modules\warehouse\models\Favorite;
use app\modules\warehouse\models\NomenclatureProduct;
use app\modules\warehouse\models\Product;
use app\modules\warehouse\models\ShippingRequestSearch;
use app\modules\warehouse\models\Warehouse;
use app\modules\warehouse\models\Shipping;
use Carbon\Carbon;
use Yii;
use app\modules\warehouse\models\ShippingProduct;
use app\modules\warehouse\models\ShippingProductSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShippingProductController implements the CRUD actions for ShippingProduct model.
 */
class ShippingProductController extends Controller
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
     * Lists all ShippingProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;

        $searchModel = new ShippingProductSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'isFavorite' => $isFavorite,

        ]);
    }

    /**
     * Displays a single ShippingProduct model.
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
     * Creates a new ShippingProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($shippingId = null)
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;

        $model = new ShippingProduct();

        $shippingModel = new Shipping();

        $dataWarehouses = ArrayHelper::map(Warehouse::find()->where(['type' => 'physical'])->asArray()->all(), 'id', 'name');
        $nProductIds = NomenclatureProduct::find()->select(['id'])->asArray()->all();

        $uersData = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])->asArray()->all(), 'name', 'last_name' , 'id');

        $dataUsers = [];
        foreach ($uersData as $key => $value) {
            $dataUsers[$key] = $value[array_key_first($value)] . ' ' . array_key_first($value);
        }

        $nProducts = ArrayHelper::map($nProductIds , 'id', 'name');

        $products = Product::find()->select([
            'id',
            'nomenclature_product_id',
            'price'
        ])->asArray()->all();
        $model->created_at  = Carbon::now()->toDateTimeString();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $shippingModel->shipping_type = $post['Shipping']['shipping_type'];
            $shippingModel->provider_warehouse_id = $post['Shipping']['provider_warehouse_id'];
            $shippingModel->supplier_warehouse_id = $post['Shipping']['supplier_warehouse_id'];
            $shippingModel->user_id = $post['Shipping']['user_id'];
            $shippingModel->created_at  = Carbon::now()->toDateTimeString();
            $shippingModel->status = 'Ուղղարկված';
            $shippingModel->save();

            foreach ($post["ShippingProduct"]['product_id'] as $productId) {
                $model = new ShippingProduct();
                $model->shipping_id = $shippingModel->id;
                $model->product_id = $productId;
                $model->created_at  = Carbon::now()->toDateTimeString();
                $model->save();

            }
            if (array_key_exists('individual_product_id', $post["ShippingProduct"])) {

                $productIds = $post["ShippingProduct"]['individual_product_id'];
                $productsCount = $post["ShippingProduct"]['count'];
                //varDumper($productIds, $productsCount, $post);die;
                if (!empty($productIds)) {
                    for ($i = 0; $i < count($productIds); $i++ ) {
                        $nProducts = Product::find()->where(['warehouse_id' => $shippingModel->provider_warehouse_id, 'nomenclature_product_id' => $productIds[$i]])
                            ->orderBy(['created_at' => SORT_ASC])
                            ->all();
                        foreach ($nProducts as $nProduct) {
                            if ($nProduct->count > $productsCount[$i]) {
                                $model = new ShippingProduct();
                                $model->shipping_id = $shippingModel->id;
                                $model->product_id = $nProduct->id;
                                $model->count = $productsCount[$i];
                                $model->created_at  = Carbon::now()->toDateTimeString();
                                $model->save();
                                break;
                            } else {
                                $model = new ShippingProduct();
                                $model->shipping_id = $shippingModel->id;
                                $model->product_id = $nProduct->id;
                                $model->count = $productsCount[$i];
                                $model->created_at  = Carbon::now()->toDateTimeString();
                                $model->save();
                                $productsCount[$i] = $productsCount[$i] -= $nProduct->count ;
                            }
                        }

                    }
                }

            }

            return $this->redirect(['view','isFavorite' => $isFavorite,
                'id' => $model->id]);
        }
        $searchModel = null;
        $dataProvider = null;
        if ($shippingId !== null) {
            $searchModel = new ShippingRequestSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $shippingId);
        }

        return $this->render('create', [
            'model' => $model,
            'shippingModel' => $shippingModel,
            'dataWarehouses' => $dataWarehouses,
            'dataUsers'=>$dataUsers,
            'nProducts' => $nProducts,
            'searchModel' => $searchModel,
            'isFavorite' => $isFavorite,

            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing ShippingProduct model.
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
            return $this->redirect(['view',            'isFavorite' => $isFavorite,
                'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'isFavorite' => $isFavorite,

        ]);
    }

    /**
     * Deletes an existing ShippingProduct model.
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
     * Finds the ShippingProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShippingProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShippingProduct::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetNProductByWarehouse() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $post = Yii::$app->request->post();
        if (empty($post['id'])) {
            return [];
        }

        return BaseQuery::renderNProduct($post['id']);
    }
    public function actionGetMacAddressByWarehouse() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $post = Yii::$app->request->post();

        if (empty($post['n_product_id'] && $post['warehouse_id'])) {
            return [];
        }

        $data_sipping = [
            'count_partial' => $this->renderPartial('@warehouse/views/shipping-product/partial/nomenclature_product_individual_count'),
            'mac_partial' => $this->renderPartial('@warehouse/views/shipping-product/partial/products_mac_address'),
            'data_nProducts' => BaseQuery::renderProductMacAddres($post['n_product_id'] ,$post['warehouse_id'])
        ];

        return $data_sipping;
    }
}
