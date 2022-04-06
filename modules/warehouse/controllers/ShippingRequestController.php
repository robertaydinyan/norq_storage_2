<?php
namespace app\modules\warehouse\controllers;

use app\components\Url;
use app\models\Notifications;
use app\models\User;
use app\modules\warehouse\models\Favorite;
use app\modules\warehouse\models\NomenclatureProduct;
use app\modules\warehouse\models\PartnersList;
use app\modules\warehouse\models\Product;
use app\modules\warehouse\models\ProductShippingLog;
use app\modules\warehouse\models\Balance;
use app\modules\warehouse\models\ShippingType;
use app\modules\warehouse\models\SuppliersList;
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
        $lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
        $columns = TableRowsStatus::find()->where(['page_name' => 'ShippingRequest', 'userID' => Yii::$app->user->id, 'status' => 1, 'type' =>Yii::$app
            ->request->get('type')])->orderBy('order')->all();
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $searchModel = new ShippingRequestSearch();
        $shipping_types = ShippingType::find()->all();
        $dataProvider = $searchModel->search(Yii::$app
            ->request
            ->queryParams);
        $physicalWarehouse = ArrayHelper::map(Warehouse::find()->where(['type' => [1, 2]])
            ->asArray()
            ->all() , 'id', 'name_' . $lang);
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
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'shipping_types' => $shipping_types,
            'warehouses' => $physicalWarehouse,
            'suppliers' => $suppliers,
            'isFavorite' => $isFavorite,
            'columns' => $columns,

            'users' => $dataUsers]);
    }
    public function actionDocuments() {
        $lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
        TableRowsStatus::checkRows('ShippingRequest');
        $columns = TableRowsStatus::find()->where(['page_name' => 'ShippingRequest', 'userID' => Yii::$app->user->id, 'status' => 1, 'type' => Yii::$app->request->get('type')])->orderBy('order')->all();
        $searchModel = new ShippingRequestSearch();
        $shipping_types = ShippingType::find()->all();
        $dataProvider = $searchModel->search(Yii::$app
            ->request->queryParams, null, true);
        $physicalWarehouse = ArrayHelper::map(Warehouse::find()->where(['type' => [1, 2]])
            ->asArray()
            ->all() , 'id', 'name_' . $lang);
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
        return $this->render('index', ['searchModel' => $searchModel,'isFavorite' => $isFavorite, 'columns' => $columns,
            'dataProvider' => $dataProvider, 'shipping_types' => $shipping_types, 'warehouses' => $physicalWarehouse, 'suppliers' => $suppliers, 'users' => $dataUsers]);
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

        $model->created_at = Carbon::now()
            ->toDateTimeString();
        $nProducts = ArrayHelper::map(NomenclatureProduct::find()->asArray()
            ->all() , 'id', 'name');
        $physicalWarehouse = ArrayHelper::map(Warehouse::find()->where(['type' => 1])
            ->asArray()
            ->all() , 'id', 'name');

        return $this->renderAjax('create-product', ['model' => $model,'isFavorite' => $isFavorite,
            'nProducts' => $nProducts, 'physicalWarehouse' => $physicalWarehouse, ]);
    }
    public function actionCreate() {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $model = new ShippingRequest();
        $lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
        $dataWarehouses = ArrayHelper::map(Warehouse::find()->asArray()
            ->all() , 'id', 'name');
        $uersData = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])
            ->asArray()
            ->all() , 'name', 'last_name', 'id');
        $types = ArrayHelper::map(ShippingType::find()->asArray()
            ->all() , 'id', 'name_' . $lang);

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
            if (!isset($request['ShippingRequest']['supplier_id_phys'])) {
                $model->supplier_id = $request['ShippingRequest']['supplier_id'];
                $model->is_phys = 0;
            }
            else {
                $model->supplier_id = $request['ShippingRequest']['supplier_id_phys'];
                $model->is_phys = 1;
            }
            if ($request['ShippingRequest']['date_create']) {
                $model->created_at = date('Y-m-d', strtotime($request['ShippingRequest']['date_create']));
            }
            else {
                $model->created_at = date('Y-m-d');
            }
            $for_notice = 0;

            $model->user_id = $request['ShippingRequest']['user_id'];
            if ($model->shipping_type != 2 && $model->shipping_type != 6 && $model->shipping_type != 5) {
                if (isset($request['ShippingRequest']['nomenclature_product_id']) && !empty($request['ShippingRequest']['nomenclature_product_id'])) {
                    foreach ($request['ShippingRequest']['nomenclature_product_id'] as $key => $nProductId) {
                        if ($request['ShippingRequest']['count'][$key]) {
                            $Origin_product = Product::findOne($nProductId);
                            $NomenclatureProduct = NomenclatureProduct::find()->where(['id' => $Origin_product
                                ->nomenclature_product_id])
                                ->one();
                            if (intval($NomenclatureProduct->qty_for_notice) <= intval($request['ShippingRequest']['count'][$key]) || intval($NomenclatureProduct->is_vip)) {
                                $for_notice += 1;
                            }
                        }
                    }
                }
            }
            else if ($model->shipping_type == 6) {
                $for_notice = 1;
            }

            if ($for_notice || $model->shipping_type == 5) {
                $model->status = 5;
            }
            else {
                $model->status = 2;
            }
            $model->count = count($request['ShippingRequest']['nomenclature_product_id']);

            if ($model->save(false)) {
                if ($for_notice) {
                    if ($model->shipping_type != 6 && $model->shipping_type != 5 && $model->shipping_type != 2) {
                        $admins = User::find()->where(['role' => 'admin'])
                            ->all();
                        if (!empty($admins)) {
                            foreach ($admins as $key => $value) {
                                Notifications::setNotification($value->id, "Ստեղծվել է տեղափոխություն թույլատրվող քանակը գերազանցող ապրանքների ", '/warehouse/shipping-request/view?id=' . $model->id, '/warehouse/shipping-request/accept-admin?id=' . $model->id, '/warehouse/shipping-request/decline-admin?id=' . $model->id);
                            }
                        }
                    }
                    else {
                        if ($model->shipping_type != 5) {
                            $admins = User::find()->where(['role' => 'admin'])
                                ->all();
                            if (!empty($admins)) {
                                foreach ($admins as $key => $value) {
                                    Notifications::setNotification($value->id, "Ստեղծվել է <b>Գնում</b>  ", '/warehouse/shipping-request/view?id=' . $model->id, '/warehouse/shipping-request/accept-admin?id=' . $model->id, '/warehouse/shipping-request/decline-admin?id=' . $model->id);
                                }
                            }
                        }
                        else {
                            Notifications::setNotification($model->user_id, "Ստեղծվել է գնման հայտ ", '/warehouse/shipping-request/view?id=' . $model->id, '/warehouse/shipping-request/accept-admin?id=' . $model->id, '/warehouse/shipping-request/decline-admin?id=' . $model->id);
                        }
                    }
                }
                ShippingRequest::addShippingProducts($model, $request);
            }
            if ($for_notice) {
                Notifications::setNotification($model
                    ->provider->responsible_id, "Ստեղծվել է " . $model
                    ->shippingtype->name_hy . " <b>" . $model
                    ->provider->name_hy . "</b> - <b>" . $model
                    ->supplier->name_hy . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
                Notifications::setNotification($model
                    ->supplier->responsible_id, "Ստեղծվել է " . $model
                    ->shippingtype->name_hy . " <b>" . $model
                    ->provider->name_hy . "</b> - <b>" . $model
                    ->supplier->name_hy . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
                if (($model
                    ->supplier->responsible_id != $model->user_id) && ($model
                    ->provider->responsible_id != $model->user_id)) {
                    Notifications::setNotification($model->user_id, "Ստեղծվել է " . $model
                        ->shippingtype->name_hy . " <b>" . $model
                        ->provider->name_hy . "</b> - <b>" . $model
                        ->supplier->name_hy . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
                }
            }
            return $this->redirect(['index','isFavorite' => $isFavorite,]);
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
            if ($model->shipping_type != 2 && $model->shipping_type != 6) {
                if (isset($request['ShippingRequest']['nomenclature_product_id']) && !empty($request['ShippingRequest']['nomenclature_product_id'])) {
                    foreach ($request['ShippingRequest']['nomenclature_product_id'] as $key => $nProductId) {
                        if ($request['ShippingRequest']['count'][$key]) {
                            $Origin_product = Product::findOne($nProductId);
                            $NomenclatureProduct = NomenclatureProduct::find()->where(['id' => $Origin_product
                                ->nomenclature_product_id])
                                ->one();
                            if (intval($NomenclatureProduct->qty_for_notice) <= intval($request['ShippingRequest']['count'][$key]) || intval($NomenclatureProduct->is_vip)) {
                                $for_notice += 1;
                            }

                        }
                    }
                }
            }
            if ($for_notice) {
                $model->status = 5;
            }
            else {
                $model->status = 2;
            }

            $model->count = $model->count + count($request['ShippingRequest']['nomenclature_product_id']);

            $model->comment = $request['ShippingRequest']['comment'];
            if ($model->save(false)) {
                ShippingRequest::addShippingProducts($model, $request);
            }
            Notifications::setNotification(1, "Փոփոխվել է " . $model
                ->shippingtype->name_hy . " <b>" . $model
                ->provider->name_hy . "</b> - <b>" . $model
                ->supplier->name_hy . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            Notifications::setNotification($model
                ->provider->responsible_id, "Փոփոխվել է " . $model
                ->shippingtype->name_hy . " <b>" . $model
                ->provider->name_hy . "</b> -  <b>" . $model
                ->supplier->name_hy . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            Notifications::setNotification($model
                ->supplier->responsible_id, "Փոփոխվել է " . $model
                ->shippingtype->name_hy . " <b>" . $model
                ->provider->name_hy . "</b> - <b>" . $model
                ->supplier->name_hy . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            if (($model
                ->supplier->responsible_id != $model->user_id) && ($model
                ->provider->responsible_id != $model->user_id)) {
                Notifications::setNotification($model->user_id, "Փոփոխվել է " . $model
                    ->shippingtype->name_hy . " <b>" . $model
                    ->provider->name_hy . "</b> - <b>" . $model
                    ->supplier->name_hy . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            }

            return $this->redirect(['index','isFavorite' => $isFavorite,
            ]);
        }
        $nProducts = ArrayHelper::map(NomenclatureProduct::find()->asArray()
            ->all() , 'id', 'id');
        return $this->render('update', ['model' => $model,'isFavorite' => $isFavorite,
            'dataWarehouses' => $dataWarehouses, 'dataUsers' => $dataUsers, 'suppliers' => $suppliers, 'requests' => $requests, 'nProducts' => $nProducts, 'partners' => $partners, 'types' => $types]);
    }
    public function actionAccept() {
        $get = Yii::$app
            ->request
            ->get();
        if (intval($get['id'])) {
            $model = $this->findModel(intval($get['id']));
            if ($model->shipping_type == 7) {
                $total = 0;
                $products = ShippingProducts::find()->where(['shipping_id' => $model
                    ->id])
                    ->all();
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

                    if ($model
                        ->supplier->type == 4 || $model
                        ->supplier->type == 5) {

                        $addr = ContactAdress::find()->where(['id' => $model
                            ->supplier
                            ->contact_address_id])
                            ->one();
                        $costObj = new Cost();
                        $costObj->cost_date = $model->created_at;
                        $costObj->creation_date = $model->created_at;
                        $costObj->cost_type = 7;
                        $costObj->cost_sum = $prod_val->price * $prod_val->count;
                        if ($prod_val->action_type == 1) {
                            $costObj->is_internet = 1;
                        }
                        else {
                            $costObj->is_internet = 0;
                        }
                        if ($prod_val->action_type == 2) {
                            $costObj->is_ip = 1;
                        }
                        else {
                            $costObj->is_ip = 0;
                        }
                        if ($prod_val->action_type == 3) {
                            $costObj->is_tv = 1;
                        }
                        else {
                            $costObj->is_tv = 0;
                        }
                        $costObj->place = $addr->country_id . '/' . $addr->region_id . '/' . $addr->city_id . '/' . $addr->community_id;
                        $costObj->place_text = '';
                        $costObj->insert();
                    }
                }

            }
            if ($model->shipping_type == 8) {

                $products = ShippingProducts::find()->where(['shipping_id' => $model
                    ->id])
                    ->all();
                foreach ($products as $product => $prod_val) {

                    $addr = ContactAdress::find()->where(['id' => $model
                        ->provider
                        ->contact_address_id])
                        ->one();
                    $costObj = new Cost();
                    $costObj->cost_date = $model->created_at;
                    $costObj->creation_date = $model->created_at;
                    $costObj->cost_type = 7;
                    $costObj->cost_sum = $prod_val->price * $prod_val->count;
                    if ($prod_val->action_type == 1) {
                        $costObj->is_internet = 1;
                    }
                    else {
                        $costObj->is_internet = 0;
                    }
                    if ($prod_val->action_type == 2) {
                        $costObj->is_ip = 1;
                    }
                    else {
                        $costObj->is_ip = 0;
                    }
                    if ($prod_val->action_type == 3) {
                        $costObj->is_tv = 1;
                    }
                    else {
                        $costObj->is_tv = 0;
                    }
                    if ($addr) {
                        $costObj->place = $addr->country_id . '/' . $addr->region_id . '/' . $addr->city_id . '/' . $addr->community_id;
                    }
                    else {
                        $costObj->place = '';
                    }
                    $costObj->place_text = '';
                    $costObj->insert();
                }

            }
            if ($model->shipping_type == 9) {

                $total = 0;
                $products = ShippingProducts::find()->where(['shipping_id' => $model
                    ->id])
                    ->all();
                foreach ($products as $product => $prod_val) {
                    $total += ($prod_val->price * $prod_val->count);
                }

                if ($model->is_phys) {
                    $Balance = new Balance();
                    $Balance->date_create = $model->created_at;
                    $Balance->warehouse_id = $model->provider_warehouse_id;
                    $Balance->cost = $total;
                    $Balance->status = 0;
                    $Balance->deal_number = $model->supplier_id;
                    $Balance->save();
                }
            }

            if ($model->shipping_type == 2 || $model->shipping_type == 6) {
                $products = Product::find()->where(['shipping_id' => $model
                    ->id])
                    ->all();
                foreach ($products as $product => $prod_val) {
                    $product = Product::findOne($prod_val->id);
                    $product->status = 1;
                    $product->save(false);
                }
            }
            $model->status = 3;
            $model->save(false);

            $products = ShippingProducts::find()->where(['shipping_id' => $model
                ->id])
                ->all();
            $lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
            foreach ($products as $product => $prod_val) {
                $product_full_data = $prod_val->findByProductId($prod_val->product_id) [0];

                if ($product_full_data['individual'] == 'true') {
                    $log = new ProductShippingLog();
                    if ($model->shipping_type == 2 || $model->shipping_type == 6) {
                        $log->from_ = SuppliersList::findOne(['id' => $model
                            ->supplier_id])->name;
                    }
                    else {
                        $log->from_ = $model
                            ->provider->{'name_' . $lang};
                    }
                    $log->to_ = $model
                        ->supplier->{'name_' . $lang};
                    $log->mac_address = $product_full_data['mac'];
                    $log->shipping_type = $model->shipping_type;
                    $log->request_id = $model->id;
                    $log->date_create = $model->created_at;
                    $log->save(false);
                }

            }

            Notifications::setNotification($model
                ->provider->responsible_id, "Հաստատվել է " . $model
                ->shippingtype->{'name_' . $lang} . " <b>" . $model
                ->provider->{'name_' . $lang} . "</b> -  <b>" . $model
                ->supplier->{'name_' . $lang} . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            Notifications::setNotification($model
                ->supplier->responsible_id, "Հաստատվել է " . $model
                ->shippingtype->{'name_' . $lang} . " <b>" . $model
                ->provider->{'name_' . $lang} . "</b> - <b>" . $model
                ->supplier->{'name_' . $lang} . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            if (($model
                ->supplier->responsible_id != $model->user_id) && ($model
                ->provider->responsible_id != $model->user_id)) {
                Notifications::setNotification($model->user_id, "Հաստատվել է " . $model
                    ->shippingtype->{'name_' . $lang} . " <b>" . $model
                    ->provider->{'name_' . $lang} . "</b> - <b>" . $model
                    ->supplier->{'name_' . $lang} . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            }
        }
        return $this->redirect(['index']);
    }
    public function actionAcceptAdmin() {
        $get = Yii::$app
            ->request
            ->get();
        if (intval($get['id'])) {
            $model = $this->findModel(intval($get['id']));
            $model->status = 2;
            $model->save(false);
            Notifications::setNotification($model
                ->provider->responsible_id, "Ստեղծվել է " . $model
                ->shippingtype->name_hy . " <b>" . $model
                ->provider->name_hy . "</b> - <b>" . $model
                ->supplier->name_hy . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            Notifications::setNotification($model
                ->supplier->responsible_id, "Ստեղծվել է " . $model
                ->shippingtype->name_hy . " <b>" . $model
                ->provider->name_hy . "</b> - <b>" . $model
                ->supplier->name_hy . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            if (($model
                ->supplier->responsible_id != $model->user_id) && ($model
                ->provider->responsible_id != $model->user_id)) {
                Notifications::setNotification($model->user_id, "Ստեղծվել է " . $model
                    ->shippingtype->name_hy . " <b>" . $model
                    ->provider->name_hy . "</b> - <b>" . $model
                    ->supplier->name_hy . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            }
        }
        return $this->redirect(['index']);
    }
    public function actionDeclineAdmin() {
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
                    $newProduct->id = null;
                    $newProduct->status = 1;
                    $newProduct->isNewRecord = true;
                    $newProduct->created_at = $model->created_at;
                    $newProduct->warehouse_id = $model->provider_warehouse_id;
                    $newProduct->count = $prod_val->count;
                    $newProduct->save(false);
                }
            }

            Notifications::setNotification($model
                ->provider->responsible_id, "Մերժվել է " . $model
                ->shippingtype->name_hy . " <b>" . $model
                ->provider->name_hy . "</b> -  <b>" . $model
                ->supplier->name_hy . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            Notifications::setNotification($model
                ->supplier->responsible_id, "Մերժվել է " . $model
                ->shippingtype->name_hy . " <b>" . $model
                ->provider->name_hy . "</b> - <b>" . $model
                ->supplier->name_hy . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            if (($model
                ->supplier->responsible_id != $model->user_id) && ($model
                ->provider->responsible_id != $model->user_id)) {
                Notifications::setNotification($model->user_id, "Մերժվել է " . $model
                    ->shippingtype->name_hy . " <b>" . $model
                    ->provider->name_hy . "</b> - <b>" . $model
                    ->supplier->name_hy . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            }
        }
        return $this->redirect(['index']);
    }
    public function actionDecline() {
        $lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
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
                ->shippingtype->{'name_' . $lang} . " <b>" . $model
                ->provider->{'name_' . $lang} . "</b> -  <b>" . $model
                ->supplier->{'name_' . $lang} . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            Notifications::setNotification($model
                ->supplier->responsible_id, "Մերժվել է " . $model
                ->shippingtype->{'name_' . $lang} . " <b>" . $model
                ->provider->{'name_' . $lang} . "</b> - <b>" . $model
                ->supplier->{'name_' . $lang} . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            if (($model
                ->supplier->responsible_id != $model->user_id) && ($model
                ->provider->responsible_id != $model->user_id)) {
                Notifications::setNotification($model->user_id, "Մերժվել է " . $model
                    ->shippingtype->{'name_' . $lang} . " <b>" . $model
                    ->provider->{'name_' . $lang} . "</b> - <b>" . $model
                    ->supplier->{'name_' . $lang} . "</b> ", '/warehouse/shipping-request/view?id=' . $model->id);
            }

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