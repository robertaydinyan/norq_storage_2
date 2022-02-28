<?php

namespace app\modules\warehouse\controllers;

use app\models\query\BaseQuery;
use app\models\User;
use app\modules\warehouse\models\Complectation;
use app\modules\warehouse\models\NomenclatureProduct;
use app\modules\warehouse\models\Product;
use app\modules\warehouse\models\Warehouse;
use Carbon\Carbon;
use Yii;
use app\modules\warehouse\models\ComplectationShipping;
use app\modules\warehouse\models\ComplectationShippingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ComplectationShippingController implements the CRUD actions for ComplectationShipping model.
 */
class ComplectationShippingController extends Controller
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
     * Lists all ComplectationShipping models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ComplectationShippingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ComplectationShipping model.
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
     * Creates a new ComplectationShipping model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ComplectationShipping();

        $complectationModel = new Complectation();

        $dataWarehouses = ArrayHelper::map(Warehouse::find()->where(['type' => 'physical'])->asArray()->all(), 'id', 'name');
        $nProductIds = NomenclatureProduct::find()->select(['id'])->asArray()->all();

        $nProductsName = ArrayHelper::map(NomenclatureProduct::find()->asArray()->all(), 'id', 'name');

        $uersData = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])->asArray()->all(), 'name', 'last_name' , 'id');

        $dataUsers = [];
        foreach ($uersData as $key => $value) {
            $dataUsers[$key] = $value[array_key_first($value)] . ' ' . array_key_first($value);
        }

        $nProducts = ArrayHelper::map($nProductIds , 'id', 'name');

//        $products = Product::find()->select([
//            'id',
//            'nomenclature_product_id',
//            'price'
//        ])->asArray()->all();
//        $model->created_at  = Carbon::now()->toDateTimeString();
       // varDumper($model->load(Yii::$app->request->post()));die;
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $complectationModel->provider_warehouse_id = $post['Complectation']['provider_warehouse_id'];
            $complectationModel->supplier_warehouse_id = $post['Complectation']['supplier_warehouse_id'];
            $complectationModel->nomenclature_product_id = $post['Complectation']['nomenclature_product_id'];
            $complectationModel->service_fee = $post['Complectation']['service_fee'];
            $complectationModel->new_product_count = $post['Complectation']['new_product_count'];
            $complectationModel->created_at =  Carbon::now()->toDateTimeString();
            $complectationModel->save(false);

            foreach ($post["ComplectationShipping"]['product_id'] as $productId) {
                $model = new ComplectationShipping();
                $model->complectation_id = $complectationModel->id;
                $model->product_id = $productId;
                $model->product_id = $productId;
                $model->save();

            }
            if (array_key_exists('individual_product_id', $post["ComplectationShipping"])) {

                $productIds = $post["ComplectationShipping"]['individual_product_id'];
                $productsCount = $post["ComplectationShipping"]['count'];
                if (!empty($productIds)) {
                    for ($i = 0; $i < count($productIds); $i++ ) {
                        $nProducts = Product::find()->where(['warehouse_id' => $complectationModel->provider_warehouse_id, 'nomenclature_product_id' => $productIds[$i]])
                            ->orderBy(['created_at' => SORT_ASC])
                            ->all();
                        foreach ($nProducts as $nProduct) {
                            if ($nProduct->count > $productsCount[$i]) {
                                $model = new ComplectationShipping();
                                $model->complectation_id = $complectationModel->id;
                                $model->product_id = $nProduct->id;
                                $model->n_product_count = $productsCount[$i];
                                $model->save();
                                break;
                            } else {
                                $model = new ComplectationShipping();
                                $model->complectation_id = $complectationModel->id;
                                $model->product_id = $nProduct->id;
                                $model->n_product_count = $productsCount[$i];
                                $model->save();
                                $productsCount[$i] = $productsCount[$i] -= $nProduct->count ;
                            }
                        }

                    }
                }

            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'complectationModel' => $complectationModel,
            'dataWarehouses' => $dataWarehouses,
            'dataUsers'=>$dataUsers,
            'nProducts' => $nProducts,
            'nProductsName' =>  $nProductsName,
        ]);
    }

    /**
     * Updates an existing ComplectationShipping model.
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
     * Deletes an existing ComplectationShipping model.
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
     * Finds the ComplectationShipping model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ComplectationShipping the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ComplectationShipping::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetMacAddressByWarehouse() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $post = Yii::$app->request->post();

        if (empty($post['n_product_id'] && $post['warehouse_id'])) {
            return [];
        }

        $data_sipping = [
            'count_partial' => $this->renderPartial('@warehouse/views/complectation-shipping/partial/nomenclature_product_individual_count'),
            'mac_partial' => $this->renderPartial('@warehouse/views/complectation-shipping/partial/products_mac_address'),
            'data_nProducts' => BaseQuery::renderProductMacAddres($post['n_product_id'] ,$post['warehouse_id'])
        ];

        return $data_sipping;
    }
}
