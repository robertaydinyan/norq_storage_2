<?php
namespace app\modules\warehouse\controllers;
use yii\data\ArrayDataProvider;
use app\components\Url;
use app\models\Notifications;
use app\models\User;
use app\modules\warehouse\models\Currency;
use app\modules\warehouse\models\Favorite;
use app\modules\warehouse\models\NomenclatureProduct;
use app\modules\warehouse\models\PartnersList;
use app\modules\warehouse\models\Product;
use app\modules\warehouse\models\ProductShippingLog;
use app\modules\warehouse\models\Balance;
use app\modules\warehouse\models\ShippingType;
use app\modules\warehouse\models\SuppliersList;
use app\modules\warehouse\models\TableRowsCount;
use app\modules\warehouse\models\TableRowsStatus;
use app\modules\warehouse\models\Warehouse;
use app\rbac\WarehouseRule;
use Carbon\Carbon;
use Yii;
use app\modules\warehouse\models\ShippingRequest;
use app\modules\warehouse\models\ShippingProducts;
use app\modules\warehouse\models\ShippingRequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\modules\crm\models\ContactAdress;
use app\modules\reports\models\Cost;

/**
 * ShippingRequestController implements the CRUD actions for ShippingRequest model.
 */
class ShippingRequestController extends Controller {
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return ['verbs' => ['class' => VerbFilter::className() , 'actions' => ['delete' => ['POST'], ], ], ];
    }

    /**
     * Lists all ShippingRequest models.
     * @return mixed
     */
    public function actionIndex() {
        TableRowsStatus::checkRows('ShippingRequest', Yii::$app->request->get('type'));
        $columns = TableRowsStatus::find()->where(['page_name' => 'ShippingRequest', 'userID' => Yii::$app->user->id, 'status' => 1, 'type' => Yii::$app
            ->request->get('type')])->orderBy('order')->all();
        $rows_count = TableRowsCount::find()->where(['page_name' => 'ShippingRequest', 'userID' => Yii::$app->user->id])->one();
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $searchModel = new ShippingRequestSearch();
        $shipping_types = ShippingType::find()->orderBy(['order_'=>SORT_ASC])->all();
        $dataProvider = $searchModel->search(Yii::$app
            ->request
            ->queryParams);
        $physicalWarehouse = ArrayHelper::map(Warehouse::find()->where(['type' => 1])
            ->asArray()
            ->all() , 'id', 'name');
        $uersData = User::find()->where(['status' => User::STATUS_ACTIVE])
            ->all();
        $dataUsers = [];
        foreach ($uersData as $key => $value) {

            $dataUsers[$value
                ->id] = $value->name . ' ' . $value->last_name;
        }
        $suppliers = $this->buildTree(SuppliersList::find()
            ->where(['!=', 'id', 6])
            ->asArray()
            ->all());
        $dataProvider->pagination->pageSize = $rows_count['count'];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'shipping_types' => $shipping_types,
            'warehouses' => $physicalWarehouse,
            'suppliers' => $suppliers,
            'isFavorite' => $isFavorite,
            'columns' => $columns,

            'users' => $dataUsers
        ]);
    }
    public function actionDocuments() {
        TableRowsStatus::checkRows('ShippingRequest');
        $columns = TableRowsStatus::find()->where(['page_name' => 'ShippingRequest', 'userID' => Yii::$app->user->id, 'status' => 1, 'type' => Yii::$app->request->get('type')])->orderBy('order')->all();
        $rows_count = TableRowsCount::find()->where(['page_name' => 'ShippingRequest', 'userID' => Yii::$app->user->id])->one();
        $searchModel = new ShippingRequestSearch();
        $shipping_types = ShippingType::find()->orderBy(['order_'=>SORT_ASC])->all();
        $dataProvider = $searchModel->search(Yii::$app
            ->request->queryParams, null, true);
        $physicalWarehouse = ArrayHelper::map(Warehouse::find()->where(['type' => 1])
            ->asArray()
            ->all() , 'id', 'name');
        $uersData = User::find()->where(['status' => User::STATUS_ACTIVE])
            ->all();
        $dataUsers = [];
        $dataProvider->pagination->pageSize = $rows_count['count'];
        if ($rows_count && $rows_count->column_name) {
            $dataProvider->sort->defaultOrder = [$rows_count->column_name => ($rows_count->direction == "DESC" ? SORT_DESC : SORT_ASC)];
        }

        foreach ($uersData as $key => $value) {
            $dataUsers[$value
                ->id] = $value->name . ' ' . $value->last_name;
        }
        $suppliers = $this->buildTree(SuppliersList::find()
            ->where(['!=', 'id', 6])
            ->asArray()
            ->all());
        return $this->render('index', [
            'searchModel' => $searchModel,
            'isFavorite' => $isFavorite,
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'shipping_types' => $shipping_types,
            'warehouses' => $physicalWarehouse,
            'suppliers' => $suppliers,
            'users' => $dataUsers
        ]);
    }

    public function actionCalendar() {

        
       
        TableRowsStatus::checkRows('ShippingRequest');
        $columns = TableRowsStatus::find()->where(['page_name' => 'ShippingRequest', 'userID' => Yii::$app->user->id, 'status' => 1, 'type' => Yii::$app->request->get('type')])->orderBy('order')->all();
        $rows_count = TableRowsCount::find()->where(['page_name' => 'ShippingRequest', 'userID' => Yii::$app->user->id])->one();
      
        $shipping_types = ShippingType::find()->orderBy(['order_'=>SORT_ASC])->all();
      
        $date_start = date('01-m-Y');
        $date_end = date('31-m-Y');
        if(!isset($_GET['type'])){
             $res = ShippingRequest::find()->where(['>=','created_at',$date_start]);
             $res->where(['>=','created_at',$date_start]);
             $res->andWhere(['<=','created_at',$date_end]);
             
            if (isset($_GET['provider_warehouse_id']) && !empty($_GET['provider_warehouse_id'])) {
                       $res->andWhere(['=','provider_warehouse_id',intval($_GET['provider_warehouse_id'])]);
                    }
            if (isset($_GET['supplier_warehouse_id']) && !empty($_GET['supplier_warehouse_id'])) {
                       $res->andWhere(['=','supplier_warehouse_id',intval($_GET['supplier_warehouse_id'])]);
                    }
            if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
                       $res->andWhere(['=','user_id',intval($_GET['user_id'])]);
                    }           
                 $l =   $res->all();
                    

            
        } else {
             $res = ShippingRequest::find();          
             $res->where(['>=','created_at',$date_start]);
             $res->andWhere(['<=','created_at',$date_end]);
             $res->andWhere(['=','shipping_type',intval($_GET['type'])]);
             if (isset($_GET['provider_warehouse_id']) && !empty($_GET['provider_warehouse_id'])) {
                       $res->andWhere(['=','provider_warehouse_id',intval($_GET['provider_warehouse_id'])]);
                    }
            if (isset($_GET['supplier_warehouse_id']) && !empty($_GET['supplier_warehouse_id'])) {
                       $res->andWhere(['=','supplier_warehouse_id',intval($_GET['supplier_warehouse_id'])]);
                    }
            if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
                       $res->andWhere(['=','user_id',intval($_GET['user_id'])]);
                    }  
              $l = $res->all();

        }

        $physicalWarehouse = ArrayHelper::map(Warehouse::find()->where(['type' => 1])
            ->asArray()
            ->all() , 'id', 'name');
        $uersData = User::find()->where(['status' => User::STATUS_ACTIVE])
            ->all();
        $dataUsers = [];
        foreach ($uersData as $key => $value) {
            $dataUsers[$value
                ->id] = $value->name . ' ' . $value->last_name;
        }
        $suppliers = $this->buildTree(SuppliersList::find()
            ->where(['!=', 'id', 6])
            ->asArray()
            ->all());       


       

        return $this->render('calendar', ['searchModel' => $searchModel,'isFavorite' => $isFavorite, 'columns' => $columns,
            'dataProvider' => $l, 'shipping_types' => $shipping_types, 'warehouses' => $physicalWarehouse, 'suppliers' => $suppliers, 'users' => $dataUsers]);
    }

     public function actionCalendarAjax() {

        $month = $_POST['month_ajax'];
      
        $date_start = date('Y-'.$month.'-01');
        $date_end = date('Y-'.$month.'-31');

      
        
        
        if(!isset($_GET['type'])){
             $res = ShippingRequest::find()->where(['>=','created_at',$date_start]);
             $res->where(['>=','created_at',$date_start]);
             $res->andWhere(['<=','created_at',$date_end]);
             
            if (isset($_GET['provider_warehouse_id']) && !empty($_GET['provider_warehouse_id'])) {
                       $res->andWhere(['=','provider_warehouse_id',intval($_GET['provider_warehouse_id'])]);
                    }
            if (isset($_GET['supplier_warehouse_id']) && !empty($_GET['supplier_warehouse_id'])) {
                       $res->andWhere(['=','supplier_warehouse_id',intval($_GET['supplier_warehouse_id'])]);
                    }
            if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
                       $res->andWhere(['=','user_id',intval($_GET['user_id'])]);
                    }           
                 $l =   $res->all();
                    

            
        } else {
             $res = ShippingRequest::find();          
             $res->where(['>=','created_at',$date_start]);
             $res->andWhere(['<=','created_at',$date_end]);
             $res->andWhere(['=','shipping_type',intval($_GET['type'])]);
             if (isset($_GET['provider_warehouse_id']) && !empty($_GET['provider_warehouse_id'])) {
                       $res->andWhere(['=','provider_warehouse_id',intval($_GET['provider_warehouse_id'])]);
                    }
            if (isset($_GET['supplier_warehouse_id']) && !empty($_GET['supplier_warehouse_id'])) {
                       $res->andWhere(['=','supplier_warehouse_id',intval($_GET['supplier_warehouse_id'])]);
                    }
            if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
                       $res->andWhere(['=','user_id',intval($_GET['user_id'])]);
                    }  
              $l = $res->all();

        }       
        


        
        $color = [];
        $i = 0;
        $colors = ['#49851b','#a410e8','#b64280','#c3a115','#ab4a16','#0cff09','#f562e0','#6d1d5d','#3fe03d','#67610a','#2ffd32','#52775d'];


        foreach($l as $values){
            if ($i>0) {
               if(isset($color[$values->shipping_type])){
                continue;
               }
            }            
        $color[$values->shipping_type] = $colors[$i];
        $i++;
        }

        $js_events = [];
        foreach($l as $value){
            $js_events[] = ['title'=>$value->shippingtype->name.' '.'#'.$value->id,'start'=>$value->created_at,'url'=>'/warehouse/shipping-request/view?id='.$value->id,'color'=>$color[$value->shipping_type]];
        }
        
        return json_encode($js_events);
       

    }
    /**
     * Displays a single ShippingRequest model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        return $this->render('view', ['model' => $this->findModel($id) , 'isFavorite' => $isFavorite,
        ]);
    }
    public function actionCreateProduct($warehouseId = null) {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $model = new Product();

        $currencies = Currency::find()->all();

        $model->created_at = Carbon::now()
            ->toDateTimeString();
        $nProducts = ArrayHelper::map(NomenclatureProduct::find()->asArray()
            ->all() , 'id', 'name');
        $physicalWarehouse = ArrayHelper::map(Warehouse::find()->where(['type' => 1])
            ->asArray()
            ->all() , 'id', 'name');

        return $this->renderAjax('create-product', [
            'model' => $model,
            'isFavorite' => $isFavorite,
            'nProducts' => $nProducts,
            'physicalWarehouse' => $physicalWarehouse,
            'currencies' => $currencies
        ]);
    }
    public function actionCreate() {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $model = new ShippingRequest();
        $dataWarehouses = ArrayHelper::map(Warehouse::find()->asArray()
            ->all() , 'id', 'name');
        $uersData = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])
            ->asArray()
            ->all() , 'name', 'last_name', 'id');
        $types = ArrayHelper::map(ShippingType::find()->asArray()
            ->all() , 'id', 'name');

        $suppliers = $this->buildTree(SuppliersList::find()
            ->where(['!=', 'id', 6])
            ->asArray()
            ->all());
        $partners = $this->buildTree(SuppliersList::find()
            ->where(['!=', 'id', 7])
            ->asArray()
            ->all());

        $dataUsers = [];
        foreach ($uersData as $key => $value) {
            $dataUsers[$key] = $value[array_key_first($value) ] . ' ' . array_key_first($value);
        }

        $requests = ArrayHelper::map(ShippingRequest::find()->where(['shipping_type' => 5, 'status' => 3])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all() , 'id', 'id');
        $nProducts = ArrayHelper::map(NomenclatureProduct::find()->asArray()
            ->all() , 'id', 'id');

        if ($model->load(Yii::$app
            ->request
            ->post())) {

            $request = Yii::$app
                ->request
                ->post();
            $model->shipping_type = $request['ShippingRequest']['shipping_type'];
            $model->provider_warehouse_id = $request['ShippingRequest']['provider_warehouse_id'];
            $model->supplier_warehouse_id = $request['ShippingRequest']['supplier_warehouse_id'];
            $model->document_type = $request['ShippingRequest']['document_type'];
            $model->invoice = $request['ShippingRequest']['invoice'];
            $model->request_id = $request['ShippingRequest']['request_id'];
            $model->comment = $request['ShippingRequest']['comment'];
            $model->supplier_id = $request['ShippingRequest']['supplier_id'];
            $model->is_phys = 0;
           
            if ($request['ShippingRequest']['date_create']) {
                $model->created_at = date('Y-m-d', strtotime($request['ShippingRequest']['date_create']));
            }
            else {
                $model->created_at = date('Y-m-d');
            }
            $for_notice = 0;
            $model->user_id = $request['ShippingRequest']['user_id'];
            $model->status = 2;
            $model->count = count($request['ShippingRequest']['nomenclature_product_id']);

            if ($model->save(false)) {
                ShippingRequest::addShippingProducts($model, $request);
//                NomenclatureProduct::saveBarcodes($post['Barcodes'], $post['BarcodesNew'], $model->id);
            }
            if ($for_notice) {
                Notifications::setNotification($model
                    ->provider->responsible_id, "Ստեղծվել է " . $model
                    ->shippingtype->name . " <b>" . $model
                    ->provider->name . "</b> - <b>" . $model
                    ->supplier->name . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
                Notifications::setNotification($model
                    ->supplier->responsible_id, "Ստեղծվել է " . $model
                    ->shippingtype->name . " <b>" . $model
                    ->provider->name . "</b> - <b>" . $model
                    ->supplier->name . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            }
            return $this->redirect(['/warehouse/shipping-request/accept?id=' . $model->id]);
        }

        return $this->render('create', ['model' => $model,'isFavorite' => $isFavorite, 'dataWarehouses' => $dataWarehouses, 'dataUsers' => $dataUsers, 'nProducts' => $nProducts, 'suppliers' => $suppliers, 'requests' => $requests, 'partners' => $partners, 'types' => $types]);
    }
    public function buildTree(array $elements, $parentId = null) {

        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;

    }
    public function actionGetShippingInfo() {

        $get = Yii::$app
            ->request
            ->get();
        if (intval($get['id'])) {
            return $this->renderAjax('products-info', ['products' => ShippingProducts::findByShip(intval($get['id'])) , ]);
        }
        else {
            return [];
        }
    }

    public function actionCheckMacAddress() {

        $get = Yii::$app
            ->request
            ->get();
        if ($get['mac']) {
            $product = Product::find()->where(['mac_address' => trim($get['mac']) ])->all();
            if (!$product) {
                return json_encode(["result" => false]);
            }
            else {
                return json_encode(["result" => true]);
            }
        }
        else {
            return json_encode(["result" => false]);
        }
    }
    public function actionUpdate($id) {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $model = $this->findModel($id);
        $dataWarehouses = ArrayHelper::map(Warehouse::find()->asArray()->all() , 'id', 'name');
        $uersData = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])->asArray()->all() , 'name', 'last_name', 'id');
        $types = ArrayHelper::map(ShippingType::find()->asArray()->all() , 'id', 'name');
        $suppliers = $this->buildTree(SuppliersList::find()->where(['!=', 'id', 6])->asArray()->all());
        $partners = $this->buildTree(SuppliersList::find()->where(['!=', 'id', 7])->asArray()->all());
        $requests = ArrayHelper::map(ShippingRequest::find()->where(['shipping_type' => 5, 'status' => 3])
            ->asArray()
            ->all() , 'id', 'name');
        $dataUsers = [];
        foreach ($uersData as $key => $value) {
            $dataUsers[$key] = $value[array_key_first($value) ] . ' ' . array_key_first($value);
        }

        if (Yii::$app
            ->request
            ->post()) {
            $request = Yii::$app
                ->request
                ->post();

            $model->document_type = $request['ShippingRequest']['document_type'];
            $model->invoice = $request['ShippingRequest']['invoice'];
            $model->supplier_id = $request['ShippingRequest']['supplier_id'];
            $model->created_at = date('Y-m-d', strtotime($request['ShippingRequest']['date_create']));
            $model->user_id = $request['ShippingRequest']['user_id'];
            $for_notice = 0;

            $model->user_id = $request['ShippingRequest']['user_id'];
            $model->status = 2;
            $model->count = $model->count + count($request['ShippingRequest']['nomenclature_product_id']);

            $model->comment = $request['ShippingRequest']['comment'];
            if ($model->save(false)) {
                ShippingRequest::addShippingProducts($model, $request);
            }

            Notifications::setNotification($model
                ->provider->responsible_id, "Փոփոխվել է " . $model
                ->shippingtype->name . " <b>" . $model
                ->provider->name . "</b> -  <b>" . $model
                ->supplier->name . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            Notifications::setNotification($model
                ->supplier->responsible_id, "Փոփոխվել է " . $model
                ->shippingtype->name . " <b>" . $model
                ->provider->name . "</b> - <b>" . $model
                ->supplier->name . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);

            return $this->redirect(['/warehouse/shipping-request/accept?id=' . $model->id]);
        }
        $nProducts = ArrayHelper::map(NomenclatureProduct::find()->asArray()
            ->all() , 'id', 'id');
        return $this->render('update', ['model' => $model,'isFavorite' => $isFavorite,
            'dataWarehouses' => $dataWarehouses, 'dataUsers' => $dataUsers, 'suppliers' => $suppliers, 'requests' => $requests, 'nProducts' => $nProducts, 'partners' => $partners, 'types' => $types]);
    }
    public function actionAccept() {
        $get = Yii::$app->request->get();
        if (intval($get['id'])) {
            $model = $this->findModel(intval($get['id']));
            if ($model->shipping_type == 7) {
                $total = 0;
                $products = ShippingProducts::find()->where(['shipping_id' => $model->id])->all();
                foreach ($products as $product => $prod_val) {
                    $newProduct = Product::findOne($prod_val->product_id);
                    if ($newProduct) {
                        $newProduct->id = null;
                        $newProduct->status = 1;
                        $newProduct->isNewRecord = true;
                        $newProduct->created_at = $model->created_at;
                        $newProduct->warehouse_id = $model->supplier_warehouse_id;
                        $newProduct->count = $prod_val->count;
                        $newProduct->price = 0;
                        $newProduct->save(false);
                    }
                    $total += ($prod_val->price * $prod_val->count);

                }

            }

            if ($model->shipping_type == 2 || $model->shipping_type == 6) {
                $products = Product::find()->where(['shipping_id' => $model->id])->all();
                foreach ($products as $product => $prod_val) {
                    $product = Product::findOne($prod_val->id);
                    $product->status = 1;
                    $product->save(false);
                }
            }
            $model->status = 3;
            $model->save(false);

            $products = ShippingProducts::find()->where(['shipping_id' => $model->id])->all();
            foreach ($products as $product => $prod_val) {
                $product_full_data = $prod_val->findByProductId($prod_val->product_id) [0];

                    $log = new ProductShippingLog();
                    if ($model->shipping_type == 2 || $model->shipping_type == 6) {
                        $log->from_ = SuppliersList::findOne(['id' => $model
                            ->supplier_id])->name;
                    } else {
                        $log->from_ = $model->provider->name;
                    }
                    $log->to_ = $model->supplier->name;
                    $log->mac_address = $prod_val->product_id;
                    $log->shipping_type = $model->shipping_type;
                    $log->request_id = $model->id;
                    $log->date_create = $model->created_at;
                    $log->save(false);
                

            }

            Notifications::setNotification($model
                ->provider->responsible_id, "Հաստատվել է " . $model
                ->shippingtype->name . " <b>" . $model
                ->provider->name . "</b> -  <b>" . $model
                ->supplier->name . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            Notifications::setNotification($model
                ->supplier->responsible_id, "Հաստատվել է " . $model
                ->shippingtype->name . " <b>" . $model
                ->provider->name . "</b> - <b>" . $model
                ->supplier->name . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);

        }
        return $this->redirect(['documents']);
    }

    public function actionDecline() {
        $get = Yii::$app
            ->request
            ->get();
        if (intval($get['id'])) {
            $model = $this->findModel(intval($get['id']));
            $model->status = 4;
            $model->save();

            $products = ShippingProducts::find()->where(['shipping_id' => $model
                ->id])
                ->all();
            if (!empty($products)) {
                foreach ($products as $product => $prod_val) {
                    $newProduct = Product::findOne($prod_val->product_id);
                    if ($newProduct) {
                        $newProduct->id = null;
                        $newProduct->status = 1;
    //                    $newProduct->individual = false;
                        $newProduct->isNewRecord = true;
                        $newProduct->created_at = $model->created_at;
                        $newProduct->warehouse_id = $model->provider_warehouse_id;
                        $newProduct->count = $prod_val->count;
                        $newProduct->save(false);
                    }
                }
            }
            Notifications::setNotification($model
                ->provider->responsible_id, "Մերժվել է " . $model
                ->shippingtype->name . " <b>" . $model
                ->provider->name . "</b> -  <b>" . $model
                ->supplier->name . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            Notifications::setNotification($model
                ->supplier->responsible_id, "Մերժվել է " . $model
                ->shippingtype->name . " <b>" . $model
                ->provider->name . "</b> - <b>" . $model
                ->supplier->name . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
        }
        return $this->redirect(['index']);
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = ShippingRequest::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}