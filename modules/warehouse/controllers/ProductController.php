<?php

namespace app\modules\warehouse\controllers;

use app\components\Url;
use app\models\query\BaseQuery;
use app\models\User;
use app\modules\billing\models\Regions;
use app\modules\crm\models\ContactAdress;
use app\modules\warehouse\models\Favorite;
use app\modules\warehouse\models\GroupProduct;
use app\modules\warehouse\models\NomenclatureProduct;
use app\modules\warehouse\models\ProductImagesPath;
use app\modules\warehouse\models\ProductShippingLog;
use app\modules\warehouse\models\QtyType;
use app\modules\warehouse\models\SuppliersList;
use app\modules\warehouse\models\Warehouse;
use Carbon\Carbon;
use Yii;
use app\modules\warehouse\models\ShippingProducts;
use app\modules\warehouse\models\Product;
use app\modules\warehouse\models\ProductForRequest;
use app\modules\warehouse\models\ProductSearch;
use yii\helpers\ArrayHelper; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;

use app\models\Notifications;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
            ]
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;

        $model = new Product();
        $address = new ContactAdress();
        $nProducts = ArrayHelper::map(NomenclatureProduct::find()->asArray()->all(), 'id', 'name');
        $users = ArrayHelper::map(User::find()->where(['role' => 'manager'])->asArray()->all(), 'id', 'name');
        $groups = ArrayHelper::map(GroupProduct::find()->asArray()->all(), 'id', 'name');
        $physicalWarehouse = ArrayHelper::map(Warehouse::find()->where(['type' => 1])->asArray()->all(), 'id', 'name');
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post(),false);
        $requestSearch = Yii::$app->request->post();
        $regions = ArrayHelper::map(Regions::find()->asArray()->all(), 'id', 'name');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'address' => $address,
            'isFavorite' => $isFavorite,
            'regions' => $regions,
            'users' => $users,
            'nProducts' => $nProducts,
            'groups' => $groups,
            'physicalWarehouse' => $physicalWarehouse,
            'requestSearch' => $requestSearch
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;

        $imagesPaths = ProductImagesPath::find()
            ->select([
                'images_path'
            ])
            ->where(['product_id' => $id])
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'isFavorite' => $isFavorite,
            'imagesPaths' => $imagesPaths
        ]);
    }


    public function actionShowLog()
    {
        $mac = Yii::$app->request->get()['mac'];

        if($mac) {
            $logs = ProductShippingLog::find()->where(['mac_address'=>$mac])->all();
            return $this->renderAjax('log-popup', ['logs' => $logs]);
        }
    }
    public function actionSendNoticeProducts()
    {
        $res = Product::findForNotice();
        $admins = User::find()->where(['role'=>'admin'])->all();
        $responsible = Warehouse::find()->where(['id'=>20])->one();
        if(!empty($res)){
            foreach($res as $product => $product_val){
                if(intval($product_val['minqty']) > intval($product_val['pcount'])){
                     if($responsible->responsible_id){
                        Notifications::setNotification($responsible->responsible_id,"Հիմնական պահեստում <b>".$product_val['vendor_code']."</b> առկա  է <b style='color:red;'>".$product_val['pcount']."</b> ".$product_val['qty_type']." , մինիմալ քանակն է <b>".$product_val['minqty']."</b> ".$product_val['qty_type'],'/warehouse/warehouse/view?id=20');
                     }
                       if(!empty($admins)){
                            foreach ($admins as $key => $value) {
                               Notifications::setNotification($value->id,"Հիմնական պահեստում <b>".$product_val['vendor_code']."</b> առկա  է <b style='color:red;'>".$product_val['pcount']."</b> ".$product_val['qty_type']." , մինիմալ քանակն է <b>".$product_val['minqty']."</b> ".$product_val['qty_type'],'/warehouse/warehouse/view?id=20');
                            }
                        } 
                }
            }
        }
    }
    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($warehouseId = null)
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;

        $model = new Product();

        $model->created_at = Carbon::now()->toDateTimeString();
        $nProducts = ArrayHelper::map(NomenclatureProduct::find()->asArray()->all(), 'id', 'name');
        if ($warehouseId !== null) {
            $physicalWarehouse = ArrayHelper::map(Warehouse::find()->where(['type' => 1])->where(['id' => $warehouseId])->asArray()->all(), 'id', 'name');
        } else {
            $physicalWarehouse = ArrayHelper::map(Warehouse::find()->where(['type' => 1])->asArray()->all(), 'id', 'name');
        }
        $suppliers = ArrayHelper::map(SuppliersList::find()->asArray()->all(), 'id', 'name');
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post()['Product'];
            $imageProductId = null;

            foreach ($post['mac_address'] as $macAddress) {
                $product = new Product();
                $product->price = $post['price'];
                $product->retail_price = $post['retail_price'];
                $product->supplier_id = $post['supplier_id'];
                $product->invoice = $post['invoice'];
                $product->comment = $post['comment'];
                $product->created_at = $model->created_at;
                $product->count = $post['count'];
                if ($imageProductId == null){
                    $product->images = UploadedFile::getInstances($model, 'images');
                }
                $product->used = $post['used'];
                $product->warehouse_id = $post['warehouse_id'];
                $product->nomenclature_product_id = $post['nomenclature_product_id'];
                $product->mac_address = $macAddress;

                if ($product->save() && ($product->upload() || $imageProductId !== null)) {
                    if ($imageProductId !== null) {
                        $imagesPathProducts = ProductImagesPath::find()->where(['product_id' => $imageProductId ])->all();
                        foreach ($imagesPathProducts as $imagesPathProduct) {
                            $imagePathModel = new ProductImagesPath();
                            $imagePathModel->images_path = $imagesPathProduct->images_path;
                            $imagePathModel->product_id = $product->id;
                            $imagePathModel->save();
                        }
                    }
                    foreach ($product->images as $image) {
                        $imagePathModel = new ProductImagesPath();
                        $imagePathModel->images_path = '/uploads/' . $image->baseName . '.' . $image->extension;
                        $imagePathModel->product_id = $product->id;
                        $imagePathModel->save();
                        $imageProductId = $imagePathModel->product_id;
                    }
                }
            }
            return $this->redirect(['index','isFavorite' => $isFavorite,]);

        }
        return $this->render('create', [
            'model' => $model,
            'nProducts' => $nProducts,
            'isFavorite' => $isFavorite,

            'physicalWarehouse' => $physicalWarehouse,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;

        $model = $this->findModel($id);

        $nProducts = ArrayHelper::map(NomenclatureProduct::find()->asArray()->all(), 'id', 'name');
        $physicalWarehouse = ArrayHelper::map(Warehouse::find()->where(['type' => 'physical'])->asArray()->all(), 'id', 'name');
        $suppliers = ArrayHelper::map(SuppliersList::find()->asArray()->all(), 'id', 'name');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'isFavorite' => $isFavorite,

            'nProducts' => $nProducts,
            'physicalWarehouse' => $physicalWarehouse,
            'suppliers' => $suppliers,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionDeleteProduct($id)
    {
        $form_data = Yii::$app->request->get();
        $id = intval($form_data['id']);
        $mac =Product::findOne($id);
        ShippingProducts::deleteAll(['product_id'=>$id]);
        if($mac->mac_address){
          ProductShippingLog::deleteAll(['mac_address'=>$mac->mac_address]);
        }

        $this->findModel($id)->delete();
        return true;
    }
    public function actionDeleteLogProduct($id)
    {
        $form_data = Yii::$app->request->get();
        $id = intval($form_data['id']);
        $mac =ProductForRequest::findOne($id)->delete();
        return true;
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionGetRegionsByCountry() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $post = Yii::$app->request->post();
        if (empty($post['id'])) {
            return [];
        }

        return BaseQuery::renderRegions($post['id']);
    }

    public function actionGetPopupProductsById() {
        $post = Yii::$app->request->get();
        if($post['id']) {
            $products =  Product::find()
                ->where(['nomenclature_product_id' => $post['id'],'individual'=>'true','status'=>1])
                ->joinWith(['nProduct', 'nProduct.qtyType'])
                ->orderBy('created_at', 'desc')
                ->all();
            return $this->renderAjax('nomeclatur-popup-products', ['products'=> $products]);
        }
        return '';
    }
    public function actionGetProductInfo() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->get();

        if(!isset($post['wId'])) {
            return NomenclatureProduct::findOne($post['id']);
        } else if($post['wId'] && $post['id']) {
            return Product::find()
                ->where(['warehouse_id'=>$post['wId'],'nomenclature_product_id' => $post['id']])
                ->joinWith(['nProduct', 'nProduct.qtyType'])
                ->select([
                    ' nomenclature_product_id, sum(count) AS count_n_product',
                ])
                ->groupBy('mac_address,nomenclature_product_id', 'count')
                ->orderBy('created_at', 'desc')
                ->all();
        } else {
            if(isset($post['date_']) && !isset($post['nid'])){
                $prods = Product::find()->select('s_product.*,SUM(count) as count')
                    ->where(['warehouse_id'=>$post['wId'],'status' => 1])
                    ->andWhere(['<=','created_at',date('Y-m-d',strtotime($post['date_']))])
                    ->andWhere(['>','count',0])
                    ->groupBy('nomenclature_product_id')
                    ->orderBy('created_at', 'desc')
                    ->asArray()->all();
                   // mac_address

            } else if(isset($post['date_']) && isset($post['nid'])){
                $nomenclature_id = Product::find()->where(['id'=>$post['nid']])->one()->nomenclature_product_id;
                 $prods = Product::find()->select('s_product.*,SUM(count) as count')
                    ->where(['warehouse_id'=>$post['wId'],'status' => 1])
                    ->andWhere(['<=','created_at',date('Y-m-d',strtotime($post['date_']))])
                    ->andWhere(['>','count',0])
                    ->andWhere(['nomenclature_product_id'=>$nomenclature_id])
                    ->groupBy('mac_address,nomenclature_product_id')
                    ->orderBy('created_at', 'desc')
                    ->asArray()->all();
            } else {
                $prods = Product::find()->select('s_product.*,SUM(count) as count')
                    ->where(['warehouse_id'=>$post['wId'],'status' => 1])
                    ->where(['>','count',0])
                    ->groupBy('mac_address,nomenclature_product_id')
                    ->orderBy('created_at', 'desc')
                    ->asArray()->all();
            }

            if(!empty($prods)){
                foreach ($prods as $product => $product_val){
                    $prods[$product]['namiclature_data'] = NomenclatureProduct::findWithInfo($product_val['nomenclature_product_id']);
                }
            }
            return $prods;
        }
    }
    public function actionGetProductsPopup(){
        $groups = GroupProduct::find()->asArray()->all();
        $tableTreeGroups = $this->buildTree($groups);
        return $this->renderAjax('nomeclatur-popup', ['tableTreeGroups'=> $tableTreeGroups]);
    }
    public function actionGetProductsPopupNomeclature(){
        $groups = GroupProduct::find()->asArray()->all();
        $tableTreeGroups = $this->buildTree($groups);
        return $this->renderAjax('popup-nomeclature-only', ['tableTreeGroups'=> $tableTreeGroups]);
    }
     
    public function buildTree(array $elements, $parentId = null) {

        $branch = array();
        foreach ($elements as $element) {
            if ($element['group_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] =  $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;

    }
}