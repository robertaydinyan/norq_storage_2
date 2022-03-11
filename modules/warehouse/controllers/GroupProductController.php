<?php

namespace app\modules\warehouse\controllers;

use app\models\Notifications;
use app\modules\warehouse\models\Product;
use app\modules\warehouse\models\SuppliersList;
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
        $lang = explode('-', \Yii::$app->language)[0] ?: 'en';

        if (Yii::$app->request->post()) {

            $form_data = Yii::$app->request->post();
            if(!isset($form_data['update_button'])) {
                $model = new GroupProduct();
                $model->name_hy = $form_data['name_hy'];
                $model->name_ru = $form_data['name_ru'];
                $model->name_en = $form_data['name_en'];
                if ($form_data['group_id']) {
                    $model->group_id = $form_data['group_id'];
                }
                $model->save(false);
            } else {
                $model = GroupProduct::find()->where(['id'=>$form_data['id']])->one();
                $model->name_hy = $form_data['name_hy'];
                $model->name_ru = $form_data['name_ru'];
                $model->name_en = $form_data['name_en'];
                $model->save(false);
            }
             return $this->redirect(['index', 'lang' => \Yii::$app->language]);
        }

        $groupProducts = Product::find()->select([
            's_product.id',
            's_product.price',
            's_product.retail_price',
            's_product.supplier_id',
            's_product.mac_address',
            's_product.comment',
            's_product.created_at',
            's_nomenclature_product.name_' . $lang . ' as n_product_name',
            's_nomenclature_product.production_date as n_product_production_date',
            's_nomenclature_product.individual as n_product_individual',
            's_nomenclature_product.qty_type_id as n_product_qty_type',
            's_group_product.name_' . $lang . ' as group_name',
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

        return $this->render('index', [
            'tableTreeGroups'=> $tableTreeGroups,
            'groupProducts' => $groupProducts,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
        $lang = explode('-', \Yii::$app->language)[0] ?: 'en';

        $haveProducts = Product::getGroupProducts($group_id);
        $groupProducts = Product::find()->select([
            's_product.id',
            's_product.price',
            's_product.retail_price',
            's_product.supplier_id',
            's_product.mac_address',
            's_product.comment',
            's_product.created_at',
            's_nomenclature_product.name_' . $lang . ' as n_product_name',
            's_nomenclature_product.production_date as n_product_production_date',
            's_nomenclature_product.individual as n_product_individual',
            's_nomenclature_product.qty_type_id as n_product_qty_type',
            's_group_product.name_' . $lang . ' as group_name',
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

        ]);
    }





    /**
     * Creates a new GroupProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GroupProduct();
        $groupProducts = ArrayHelper::map(GroupProduct::find()->asArray()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Notifications::setNotification(1,"Ստեղծվել է ապրանքի խումբ ՝ <b>".$model->name."</b> ",'/warehouse/group-product');
            return $this->redirect(['view', 'id' => $model->id, 'lang' => \Yii::$app->language]);
        }

        return $this->render('create', [
            'model' => $model,
            'groupProducts' => $groupProducts
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
        $model = $this->findModel($id);

        $groupProducts = ArrayHelper::map(GroupProduct::find()->asArray()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Notifications::setNotification(1,"փոփոխվել է ապրանքի խումբ ՝ <b>".$model->name."</b> ",'/warehouse/group-product');
            return $this->redirect(['view', 'id' => $model->id, 'lang' => \Yii::$app->language]);
        }

        return $this->render('update', [
            'model' => $model,
            'groupProducts' => $groupProducts
        ]);
    }

    /**
     * Deletes an existing GroupProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteGroup()
    {
        $form_data = Yii::$app->request->get();
        $id = intval($form_data['id']);
        Notifications::setNotification(1,"Ջնջվել է ապրանքի խումբ ՝ <b>".$id."</b> ",'/warehouse/group-product');
        $this->findModel($id)->delete();
        return true;
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
}