<?php

namespace app\modules\warehouse\controllers;

use app\components\Url;
use app\models\Notifications;
use app\modules\warehouse\models\Favorite;
use app\modules\warehouse\models\Product;
use app\modules\warehouse\models\SuppliersList;
use app\rbac\WarehouseRule;
use Yii;
use app\modules\warehouse\models\GroupProduct;
use app\modules\warehouse\models\GroupProductSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GroupProductController implements the CRUD actions for GroupProduct model.
 */
class GroupProductController extends Controller
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
     * Lists all GroupProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;

        if (Yii::$app->request->post()) {

            $form_data = Yii::$app->request->post();
            if(!isset($form_data['update_button'])) {
                $model = new GroupProduct();
                $model->name = $form_data['name'];
                if ($form_data['group_id']) {
                    $model->group_id = $form_data['group_id'];
                }
                $model->group_order = GroupProduct::find()->where(['group_id' => $model->group_id])->max('group_order');
                $model->save(false);
            } else {
                $model = GroupProduct::find()->where(['id'=>$form_data['id']])->one();
                $model->name = $form_data['name'];
                $model->save(false);
            }
             return $this->redirect(['index','isFavorite' => $isFavorite]);
        }

        $groupProducts = Product::find()->select([
            's_product.id',
            's_product.price',
            's_product.retail_price',
            's_product.supplier_id',
            's_product.mac_address',
            's_product.comment',
            's_product.created_at',
            's_nomenclature_product.name as n_product_name',
            's_nomenclature_product.production_date as n_product_production_date',
            's_nomenclature_product.individual as n_product_individual',
            's_nomenclature_product.qty_type_id as n_product_qty_type',
            's_group_product.name as group_name',
            's_group_product.id as group_id',
            's_warehouse.type as warehouse_type'
        ])
            ->leftJoin('s_nomenclature_product', '`s_nomenclature_product`.`id`= `s_product`.`nomenclature_product_id`')
            ->leftJoin('s_group_product', '`s_group_product`.`id`= `s_nomenclature_product`.`group_id`')
            ->leftJoin('s_warehouse', '`s_warehouse`.`id`= `s_product`.`warehouse_id`');
        $searchModel = new GroupProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $groups = GroupProduct::find()->orderBy('group_order')->asArray()->all();
        $tableTreeGroups = $this->buildTree($groups);

        return $this->render('index', [
            'tableTreeGroups'=> $tableTreeGroups,
            'groupProducts' => $groupProducts,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'isFavorite' => $isFavorite,


        ]);
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

    /**
     * Displays a single GroupProduct model.
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

    public function actionGetGroup($id) {
        return json_encode(GroupProduct::find()->where(['id' => $id])->asArray()->one());

    }
    /**
     * Displays a single GroupProduct model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionShowGroupProducts($group_id = null)
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;

        $haveProducts = Product::getGroupProducts($group_id);
        $groupProducts = Product::find()->select([
            's_product.id',
            's_product.price',
            's_product.retail_price',
            's_product.supplier_id',
            's_product.mac_address',
            's_product.comment',
            's_product.created_at',
            's_nomenclature_product.name as n_product_name',
            's_nomenclature_product.production_date as n_product_production_date',
            's_nomenclature_product.individual as n_product_individual',
            's_nomenclature_product.qty_type_id as n_product_qty_type',
            's_group_product.name as group_name',
            's_group_product.id as group_id',
            's_warehouse.type as warehouse_type'
        ])
            ->leftJoin('s_nomenclature_product', '`s_nomenclature_product`.`id`= `s_product`.`nomenclature_product_id`')
            ->leftJoin('s_group_product', '`s_group_product`.`id`= `s_nomenclature_product`.`group_id`')
            ->leftJoin('s_warehouse', '`s_warehouse`.`id`= `s_product`.`warehouse_id`');
        $searchModel = new GroupProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $groups = GroupProduct::find()->asArray()->all();
        $tableTreeGroups = $this->buildTree($groups);
    
        return $this->render('group_products', [
            'tableTreeGroups'=> $tableTreeGroups,
            'groupProducts' => $groupProducts,
            'haveProducts' => $haveProducts,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'isFavorite' => $isFavorite,

        ]);
    }





    /**
     * Creates a new GroupProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $model = new GroupProduct();
        $groupProducts = ArrayHelper::map(GroupProduct::find()->asArray()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post())) {
            $model->group_order = GroupProduct::find()->where(['group_id' => $model->group_id])->max('group_order');
            $model->group_order = $model->group_order ? $model->group_order : 1;
            $model->save();
            Notifications::setNotification(1,"Ստեղծվել է ապրանքի խումբ ՝ <b>".$model->name ."</b> ",'/warehouse/group-product');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'groupProducts' => $groupProducts,
            'isFavorite' => $isFavorite,
        ]);
    }

    /**
     * Updates an existing GroupProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $model = $this->findModel($id);

        $groupProducts = ArrayHelper::map(GroupProduct::find()->asArray()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Notifications::setNotification(1,"փոփոխվել է ապրանքի խումբ ՝ <b>".$model->name."</b> ",'/warehouse/group-product');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'groupProducts' => $groupProducts,
            'isFavorite' => $isFavorite,
        ]);
    }

    /**
     * Deletes an existing GroupProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        $form_data = Yii::$app->request->get();
        $id = intval($form_data['id']);
        Notifications::setNotification(1,"Ջնջվել է ապրանքի խումբ ՝ <b>".$id."</b> ",'/warehouse/group-product');
        $this->findModel($id)->delete();
        return $this->redirect(['/warehouse/group-product', 'lang' => Yii::$app->language]);
    }
    public function actionDeleteGroup()
    {
        $form_data = Yii::$app->request->get();
        $id = intval($form_data['id']);
        Notifications::setNotification(1,"Ջնջվել է ապրանքի խումբ ՝ <b>".$id."</b> ",'/warehouse/group-product');
        $p = $this->findModel($id);
        $p->isDeleted = 1 - $p->isDeleted;
        $p->save(false);
        return $this->redirect(['/warehouse/group-product', 'lang' => Yii::$app->language]);
    }
    /**
     * Finds the GroupProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GroupProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GroupProduct::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionChangeOrder() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $order = $request->post('order');
            $parentID = $request->post('parentID');
            $id = $request->post('itemID');
            $gp = GroupProduct::find()->where(['id' => $id])->one();
            if ($gp) {
                $gp->group_id = $parentID;
                $gp->group_order = $order;
                $gp->save();
                Yii::$app->db->createCommand("UPDATE s_group_product SET group_order=group_order+1 WHERE group_id" . ($gp->group_id ? " = '" . $gp->group_id . "'" : ' IS NULL') . " AND group_order >= $gp->group_order AND id <> $gp->id")->execute();
            }
         }
    }
}