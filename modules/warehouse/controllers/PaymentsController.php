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
use app\rbac\WarehouseRule;
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
 * PaymentsController implements the CRUD actions for Product model.
 */
class PaymentsController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $partners = SuppliersList::find()->asArray()->all();
        $tableTreePartners = $this->buildTree($partners);

        return $this->render('index', [
            'tableTreePartners' => $tableTreePartners,
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
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $imagesPaths = ProductImagesPath::find()
            ->select([
                'images_path'
            ])
            ->where(['product_id' => $id])
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'imagesPaths' => $imagesPaths,
            'isFavorite' => $isFavorite,
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

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($warehouseId = null)
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
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
            return $this->redirect(['index', 'isFavorite' => $isFavorite]);

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
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
   
}