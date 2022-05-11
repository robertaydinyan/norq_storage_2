<?php

namespace app\modules\warehouse\controllers;

use app\components\Url;
use app\modules\warehouse\models\Barcode;
use app\modules\warehouse\models\Favorite;
use app\modules\warehouse\models\GroupProduct;
use app\modules\warehouse\models\Manufacturer;
use app\modules\warehouse\models\QtyType;
use app\modules\warehouse\models\Vat;
use app\rbac\WarehouseRule;
use Yii;
use app\modules\warehouse\models\NomenclatureProduct;
use app\modules\warehouse\models\NomenclatureProductSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Notifications;
use app\models\User;
/**
 * NomenclatureProductController implements the CRUD actions for NomenclatureProduct model.
 */
class NomenclatureProductController extends Controller
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
     * Lists all NomenclatureProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $groups = GroupProduct::find()->asArray()->all();
        $tableTreeGroups = $this->buildTree($groups);

        $searchModel = new NomenclatureProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'tableTreeGroups'=> $tableTreeGroups,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'isFavorite' => $isFavorite,
        ]);
    }

    /**
     * Displays a single NomenclatureProduct model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
//        $dataProvider = new ActiveDataProvider([
//            'query' => Barcode::find()->where(['numenclature_id' => $id]),
//        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
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
     * Creates a new NomenclatureProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $manufacturers = ArrayHelper::map(Manufacturer::find()->where(['isDeleted' => 0])->orderBy('name')->asArray()->all(), 'id', 'name');
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $model = new NomenclatureProduct();
        $groupProducts = ArrayHelper::map(GroupProduct::find()->where(['isDeleted' => 0])->asArray()->all(), 'id', 'name');
        $qtyTypes = ArrayHelper::map(QtyType::find()->where(['isDeleted' => 0])->orderBy('type')->asArray()->all(), 'id', 'type');
        $vats = ArrayHelper::map(Vat::find()->where(['isDeleted' => 0])->orderBy('name')->asArray()->all(), 'id', 'name');

        $post = Yii::$app->request->post();


        if ((int)$post['NomenclatureProduct']['qty_type_id'] === 0 && $model->load(Yii::$app->request->post())) {
            $qtyModel = new QtyType();
//            $qtyModel->type = $post['NomenclatureProduct']['qty_type_id'];
            $qtyModel->save();
            $model->qty_type_id = $qtyModel->id;
        }

        if (empty($post['NomenclatureProduct']['individual']) && $model->load(Yii::$app->request->post())) {
//            $post['NomenclatureProduct']['production_date'] = date('Y-m-d', strtotime($post['NomenclatureProduct']['production_date']));
            $model->individual = 'false';
        }
        
        if ($model->load(Yii::$app->request->post()) ) {
            if($_FILES['image']['size'] > 0){
                $file_name = '/uploads/'.time().$_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/'.time().$_FILES['image']['name']);
                $model->img = $file_name;
            }

            $admins = User::find()->where(['role'=>'admin'])->all();
            $model->production_date = date('Y-m-d', strtotime($post['NomenclatureProduct']['production_date']));
            $model->expiration_date = date('Y-m-d', strtotime($post['NomenclatureProduct']['expiration_date']));

            if ($model->save()) {
                 if(!empty($admins)){
                    foreach ($admins as $key => $value) {
                       Notifications::setNotification($value->id,"Ստեղծվել է նոր Նոմենկլատուրա ".$model->name,'/warehouse/nomenclature-product');
                    }
                }
//                NomenclatureProduct::saveBarcodes($post['Barcodes'], $post['BarcodesNew'], $model->id);
                return $this->redirect(['index',            'isFavorite' => $isFavorite]);
            }
        }

        $groups = GroupProduct::find()->where(['isDeleted' => 0])->asArray()->all();
        $tableTreeGroups = $this->buildTree($groups);

        return $this->render('create', [
            'tableTreeGroups'=> $tableTreeGroups,
            'model' => $model,
            'groupProducts' => $groupProducts,
            'isFavorite' => $isFavorite,
            'manufacturers' => $manufacturers,
            'qtyTypes' => $qtyTypes,
            'vats' => $vats,
        ]);
    }

    /**
     * Updates an existing NomenclatureProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $manufacturers = ArrayHelper::map(Manufacturer::find()->where(['isDeleted' => 0])->orderBy('name')->asArray()->all(), 'id', 'name');
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $model = $this->findModel($id);
        $groupProducts = ArrayHelper::map(GroupProduct::find()->where(['isDeleted' => 0])->asArray()->all(), 'id', 'name');
        $qtyTypes = ArrayHelper::map(QtyType::find()->where(['isDeleted' => 0])->orderBy('type')->asArray()->all(), 'id', 'type');
        $post = Yii::$app->request->post();
        $vats = ArrayHelper::map(Vat::find()->where(['isDeleted' => 0])->orderBy('name')->asArray()->all(), 'id', 'name');
//        $barcodes = Barcode::find()->where(['numenclature_id' => $id])->all();
        if ((int)$post['NomenclatureProduct']['qty_type_id'] === 0 && $model->load(Yii::$app->request->post())) {
            $qtyModel = new QtyType();
//            $qtyModel->type = $post['NomenclatureProduct']['qty_type_id'];
            $qtyModel->save();
            $model->qty_type_id = $qtyModel->id;
        }
        if (empty($post['NomenclatureProduct']['individual']) && $model->load(Yii::$app->request->post())) {
            $model->individual = 'false';
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $admins = User::find()->where(['role'=>'admin'])->all();
            if($_FILES['image']['size'] > 0){
                $file_name = '/uploads/'.time().$_FILES['image']['name'];
                $r = move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/'.time().$_FILES['image']['name']);
             
                $model->img = $file_name;
            }
            if(!empty($admins)){
                foreach ($admins as $key => $value) {
                   Notifications::setNotification($value->id,"Փոփոխվել է Նոմենկլատուրա ".$model->name,'/warehouse/nomenclature-product');
                }
            } 
            $model->production_date = date('Y-m-d', strtotime($post['NomenclatureProduct']['production_date']));
            $model->expiration_date = date('Y-m-d', strtotime($post['NomenclatureProduct']['expiration_date']));
            if ($model->save()) {
//                NomenclatureProduct::saveBarcodes($post['Barcodes'], $post['BarcodesNew'], $model->id);
                return $this->redirect(['index']);

            }
        }

        $groups = GroupProduct::find()->where(['isDeleted' => 0])->asArray()->all();
        $tableTreeGroups = $this->buildTree($groups);

        return $this->render('update', [
            'tableTreeGroups'=> $tableTreeGroups,
            'model' => $model,
            'groupProducts' => $groupProducts,
            'isFavorite' => $isFavorite,
            'qtyTypes' => $qtyTypes,
            'manufacturers' => $manufacturers,
            'vats' => $vats
        ]);
    }

    /**
     * Deletes an existing NomenclatureProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $admins = User::find()->where(['role'=>'admin'])->all();
        if(!empty($admins)){
            foreach ($admins as $key => $value) {
               Notifications::setNotification($value->id,"Ջնջվել է Նոմենկլատուրա ".$id,'/warehouse/nomenclature-product');
            }
        }
        $p = $this->findModel($id);
        $p->isDeleted = 1 - $p->isDeleted;
        $p->save(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the NomenclatureProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NomenclatureProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NomenclatureProduct::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
