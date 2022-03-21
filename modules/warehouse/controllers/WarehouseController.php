<?php
namespace app\modules\warehouse\controllers;

use app\components\Url;
use app\modules\warehouse\models\Favorite;
use app\models\User;
use app\modules\billing\models\Regions;
use app\modules\fastnet\models\Streets;
use app\modules\rbac\filters\AccessControl;
use app\modules\warehouse\models\NomenclatureProduct;
use app\modules\warehouse\models\Product;
use app\modules\warehouse\models\ProductImagesPath;
use app\modules\warehouse\models\SearchShippingType;
use app\modules\warehouse\models\ShippingRequestSearch;
use app\modules\warehouse\models\ShippingType;
use app\modules\warehouse\models\SuppliersList;
use app\modules\warehouse\models\UserHistory;
use app\modules\warehouse\models\WarehouseGroups;
use app\modules\warehouse\models\WarehouseTypes;
use app\rbac\WarehouseRule;
use Yii;
use app\modules\warehouse\models\Warehouse;
use app\modules\warehouse\models\WarehouseSearch;
use app\modules\fastnet\models\Deal;
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Carbon\Carbon;
use yii\helpers\ArrayHelper;
use app\modules\crm\models\Company;
use app\modules\crm\models\Contact;
use app\modules\crm\models\ContactAdress;
use yii\web\UploadedFile;
use app\models\Notifications;

/**
 * WarehouseController implements the CRUD actions for Warehouse model.`
 */
class WarehouseController extends Controller {
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className() ,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Warehouse models.
     * @return mixed
     */
    public function actionIndex() {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;
        $warehouse_types = WarehouseTypes::find()->all();
        return $this->render('index', [
            'warehouse_types' => $warehouse_types,
            'isFavorite' => $isFavorite
        ]);
    }

    public function actionHome() {

        $shipping_types = ShippingType::find()->all();
        $history = UserHistory::find()->where(['user_id' => Yii::$app->user->id])->limit(20)->orderBy('time DESC')->all();
        return $this->render('home', [
            'shipping_types' => $shipping_types,
            'history' => $history
        ]);
    }
    public function actionShowByType() {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;

        $searchModel = new WarehouseSearch();
        $dataProvider = $searchModel->search(Yii::$app
            ->request
            ->queryParams);
        $warehouse_types = WarehouseTypes::find()->all();

        return $this->render('show-by-type', [
            'searchModel' => $searchModel,
            'isFavorite' => $isFavorite,
            'dataProvider' => $dataProvider,
            'warehouse_types' => $warehouse_types,
        ]);
    }

    public function actionGetWarehousesPopup() {
        return $this->renderAjax('popup-warehouses');
    }

    public function actionGetProductInfo() {
        $get = Yii::$app
            ->request
            ->get();
        if (intval($get['id'])) {
            return $this->renderAjax('products-info', ['products' => Product::find()
                ->where(['nomenclature_product_id' => intval($get['id']) , 'warehouse_id' => intval($get['wid']) , 'status' => 1])->all() , ]);
        }
        else {
            return [];
        }
    }
    public function actionByType() {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;

        $type = Yii::$app
            ->request
            ->get() ['type'];
        $region = Yii::$app
            ->request
            ->get() ['region'];
        if (intval($type)) {
            if (intval($type) != 2) {
                if (!$region) {
                    $regions = Regions::find()->all();
                    return $this->render('by-type', ['regions' => $regions, 'type' => $type]);
                }
                else {
                    $communities = Warehouse::getByRegionCommunities($region);
                    return $this->render('by-type-and-region', ['communities' => $communities, 'isFavorite' => $isFavorite,'type' => $type, 'region' => $region]);
                }
            }
            else {
                $subs = WarehouseGroups::find()->all();
                return $this->render('by-subs', ['subs' => $subs,'isFavorite' => $isFavorite]);
            }

        }
        else {
            return $this->redirect(['index','isFavorite' => $isFavorite, 'lang' => \Yii::$app->language]);
        }
    }

    /**
     * Displays a single Warehouse model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView() {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;

        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;
        $id = intval($_GET['id']);
        $whProducts = Product::getWarehouseProducts($id);
        $nProducts = ArrayHelper::map(NomenclatureProduct::find()->asArray()
            ->all() , 'id', 'name');
        $suppliers = ArrayHelper::map(SuppliersList::find()->asArray()
            ->all() , 'id', 'name');
        $physicalWarehouse = ArrayHelper::map(Warehouse::find()->where(['type' => 1])
            ->where(['id' => $id])->asArray()
            ->all() , 'id', 'name');

        if ($this->findModel($id)->contact_address_id !== null) {
            $model = $this->findModel($id);
        }

        return $this->render('view', ['model' => $this->findModel($id) , 'isFavorite' => $isFavorite,'isFavorite' => $isFavorite, 'dataProvider' => $whProducts, 'suppliers' => $suppliers, 'nProducts' => $nProducts, 'physicalWarehouse' => $physicalWarehouse,

        ]);
    }

    /**
     * Creates a new Warehouse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;

        $model = new Warehouse();
        $lang = explode('-', \Yii::$app->language)[0] ?: 'en';
        $address = new ContactAdress();

        $uersData = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])
            ->asArray()
            ->all() , 'name', 'last_name', 'id');
        $warehouse_types = ArrayHelper::map(WarehouseTypes::find()->asArray()
            ->all() , 'id', 'name_' . $lang);
        $warehouse_groups = ArrayHelper::map(WarehouseGroups::find()->asArray()
            ->all() , 'id', 'name_' . $lang);
        $dataUsers = [];
        foreach ($uersData as $key => $value) {
            $dataUsers[$key] = $value[array_key_first($value) ] . ' ' . array_key_first($value);
        }

        if ($model->load(Yii::$app
            ->request
            ->post())) {
            $post = Yii::$app
                ->request
                ->post();
            $C_C_address = $post['ContactAdress'];

            if (!empty($C_C_address['country_id']['0'])) {
                foreach ($C_C_address['country_id'] as $k => $add) {
                    $street = Streets::findOne(['id' => intval($C_C_address['street'][$k]) ]);
                    $streetId = null;
                    if (empty($street) || !$C_C_address['street'][$k]) {
                        $new_street = new Streets();
                        $new_street->name = $C_C_address['street'][$k];
                        $new_street->city_id = $C_C_address['city_id'][$k];
                        $new_street->community_id = $C_C_address['community_id'][$k];
                        if ($new_street->save()) {
                            $streetId = $new_street->id;
                        }
                    }
                    else {
                        $streetId = $street->id;
                    }

                    $addressForSave = new ContactAdress();
                    if (isset($C_C_address['community_id'][$k])) {
                        $addressForSave->community_id = $C_C_address['community_id'][$k];
                    }
                    else {
                        $addressForSave->community_id = 0;
                    }
                    $addressForSave->country_id = $C_C_address['country_id'][$k];
                    $addressForSave->region_id = $C_C_address['region_id'][$k];
                    $addressForSave->city_id = $C_C_address['city_id'][$k];
                    $addressForSave->street = $streetId;
                    $addressForSave->house = $C_C_address['house'][$k];
                    $addressForSave->housing = $C_C_address['housing'][$k];
                    $addressForSave->apartment = $C_C_address['apartment'][$k];

                    if ($addressForSave->save(false)) {
                        $model->created_at = Carbon::now()
                            ->toDateTimeString();
                        $model->contact_address_id = $addressForSave->id;
                        $model->save(false);
                    }

                }
            }
            else {
                $model->created_at = Carbon::now()
                    ->toDateTimeString();
                $model->save();
            }

            Notifications::setNotification(1, "Պահեստ՝ <b>" . $model->{'name_' . $lang} .   "</b> հաջողությամբ ստեղծվել է", '/warehouse/warehouse/view?id=' . $model->id);
            Notifications::setNotification($model->responsible_id, "Պահեստ՝ <b>" . $model->{'name_' . $lang} .  "</b> հաջողությամբ ստեղծվել է", '/warehouse/warehouse/view?id=' . $model->id);
            return $this->redirect(['index','isFavorite' => $isFavorite,
                'lang' => \Yii::$app->language]);
        }

        return $this->render('create', ['model' => $model,'isFavorite' => $isFavorite,
            'dataUsers' => $dataUsers, 'address' => $address, 'warehouse_types' => $warehouse_types, 'warehouse_groups' => $warehouse_groups, ]);
    }

    /**
     * Updates an existing Warehouse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;

        $lang = explode('-', \Yii::$app->language)[0] ?: 'en';
        $model = $this->findModel($id);
        $model->updated_at = Carbon::now()
            ->toDateTimeString();

        $uersData = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])
            ->asArray()
            ->all() , 'name', 'last_name', 'id');
        $dataUsers = [];
        foreach ($uersData as $key => $value) {
            $dataUsers[$key] = $value[array_key_first($value) ] . ' ' . array_key_first($value);
        }
        $users = User::find()->select(['name', 'last_name'])
            ->where(['status' => User::STATUS_ACTIVE])
            ->asArray()
            ->all();
        $responsiblePersons = [];
        foreach ($users as $value) {
            $responsiblePersons[$value['name'] . ' ' . $value['last_name']] = $value['name'] . ' ' . $value['last_name'];
        }
        if ($model->load(Yii::$app
            ->request
            ->post())) {
            $model->save(false);
            Notifications::setNotification(1, "Պահեստ՝ <b>" . $model->{'name_' . $lang} . "</b> հաջողությամբ փոփոխվել է", '/warehouse/warehouse/view?id=' . $model->id);
            Notifications::setNotification($model->responsible_id, "Պահեստ՝ <b>" . $model->{'name_' . $lang} . "</b> հաջողությամբ փոփոխվել է", '/warehouse/warehouse/view?id=' . $model->id);
            return $this->redirect(['view', 'id' => $model->id,'isFavorite' => $isFavorite,
                'lang' => \Yii::$app->language]);
        }

        return $this->render('update', [
            'model' => $model,
            'isFavorite' => $isFavorite,

            'dataUsers' => $dataUsers,
            'responsiblePersons' => $responsiblePersons,
            'lang' => \Yii::$app->language
        ]);
    }

    public function actionDelete($id) {
        if (Yii::$app
                ->user
                ->identity->username === 'ashotfast') {
            $this->findModel($id)->delete();
        }
        $this->redirect(['index', 'lang' => \Yii::$app->language]);
    }

    protected function findModel($id) {
        if (($model = Warehouse::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionDeal() {
        $dataWarehouses = ArrayHelper::map(Warehouse::find()->asArray()
            ->all() , 'id', 'name');
        $uersData = ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE])
            ->asArray()
            ->all() , 'name', 'last_name', 'id');

        $dataUsers = [];
        foreach ($uersData as $key => $value) {
            $dataUsers[$key] = $value[array_key_first($value) ] . ' ' . array_key_first($value);
        }

        return $this->render('deal', ['dataWarehouses' => $dataWarehouses, 'dataUsers' => $dataUsers, ]);
    }
    public function actionGetCommunity() {
        $id = intval($_GET['region_id']);
        echo '<option value="">Համայնք</option>';
        if ($id) {
            $communities = Warehouse::getByRegionCommunities($id);
            if ($communities) {

                foreach ($communities as $community => $com_val) {
                    echo '<option value="' . $com_val['id'] . '">' . $com_val['name'] . '</option>';
                }
            }
        }
    }
    public function actionGetWarehouses() {
        $query = Warehouse::find();
        if (isset($_GET['type'])) {
            $query->andFilterWhere(['s_warehouse.type' => intval($_GET['type']) , ]);
        }
        if (isset($_GET['community']) && intval($_GET['community'])) {
            $query->joinWith(['contactAdress']);
            $query->andFilterWhere(['contact_adress.community_id' => intval($_GET['community']) , ]);
        }
        echo '<option value="">Պահեստ</option>';
        $dataProvider = $query->all();
        if ($dataProvider) {
            foreach ($dataProvider as $warehouse => $ware_val) {
                echo '<option value="' . $ware_val->id . '">' . $ware_val->name . '</option>';
            }
        }
    }
    public function actionGetWarehousesByType() {
        $query = Warehouse::find();
        if (isset($_GET['virtual_type'])) {
            $query->andFilterWhere(['s_warehouse.group_id' => intval($_GET['virtual_type']) , ]);
        }
        echo '<option value="">Պահեստ</option>';
        $dataProvider = $query->all();
        if ($dataProvider) {
            foreach ($dataProvider as $warehouse => $ware_val) {
                echo '<option value="' . $ware_val->id . '">' . $ware_val->name . '</option>';
            }
        }
    }

    public function actionGetDeals() {
        $q = $_GET['q'];
        $html = '<div style="max-height:250px;overflow:auto;"><br>';
        $deals = Deal::find()->where(['like', 'deal_number', $q . '%', false])->andWhere(['!=', 'crm_contact_id', ''])
            ->all();
        if (!empty($deals)) {
            foreach ($deals as $deal => $deal_val) {
                $contact = Contact::find()->where(['id' => $deal_val
                    ->crm_contact_id])
                    ->one();
                $html .= '<div><div class="c-checkbox">
                    <input type="radio" value="' . $deal_val->deal_number . '" id="' . $deal_val->deal_number . '" class="form-control cn" name="ShippingRequest[supplier_id_phys]">
                    <label class="has-star" for="' . $deal_val->deal_number . '">' . $deal_val->deal_number . ' ( ' . $contact->name . ' ' . $contact->surname . ')</label>
                    <div class="help-block invalid-feedback"></div>
                </div></div>';

            }
        }
        $html .= '<script>
                    $(".cn").on("click",function(){
                        if($(this).is(":checked")){
                          $(".cn").not($(this)).removeAttr("checked");
                        }
                    })
               </script></div>';
        return $html;
    }

    public  function actionChangeFavorite(){
        $request = $this->request;
        if($request->isGet){
            $userID = $request->get('user_id');
            $url = $request->get('url');
            $title = $request->get('title');
            $status = $request->get('status');
            if($userID && $url){
                if($status == 1){
                    $favorite = new Favorite();
                    $favorite->user_id = $userID;
                    $favorite->link = $url;
                    $favorite->link_no_lang = WarehouseRule::removeLangFromLink($url);
                    $favorite->title = $title;
                    return $favorite->save();
                } else {
                    return Favorite::deleteAll(['user_id' => $userID,'link' => $url]);
                }
            }
        }
        return false;
    }
}

