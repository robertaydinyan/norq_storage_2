<?php

namespace app\modules\warehouse\controllers;

use app\components\Url;
use app\modules\warehouse\models\Favorite;
use app\rbac\WarehouseRule;
use Yii;
use app\modules\warehouse\models\SuppliersList;
use app\modules\warehouse\models\ShippingRequest;
use app\modules\warehouse\models\SearchSuppliersList;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Notifications;
use app\models\User; 
/**
 * SuppliersListController implements the CRUD actions for SuppliersList model.
 */
class SuppliersListController extends Controller
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
     * Lists all SuppliersList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        if (Yii::$app->request->post()) {

            $form_data = Yii::$app->request->post();
            if(!isset($form_data['update_button'])) {
                $model = new SuppliersList();
                if ($form_data['parent_id']) {
                    $model->parent_id = $form_data['parent_id'];
                }
            } else {
                $model = SuppliersList::find()->where(['id'=>$form_data['id']])->one();
            }
            $model->name_hy = $form_data['name_hy'];
            $model->name_ru = $form_data['name_ru'];
            $model->name_en = $form_data['name_en'];
            $model->vat = $form_data['vat'];
            $model->legal_address = $form_data['legal_address'];
            $model->business_address = $form_data['business_address'];
            $model->phone = $form_data['phone'];
            $model->email = $form_data['email'];
            $model->comment = $form_data['comment'];
            $model->contract_type = $form_data['contract_type'];
            $model->save(false);
            return $this->redirect(['index', 'isFavorite' => $isFavorite]);
        }
        $partners = SuppliersList::find()->asArray()->all();
        $tableTreePartners = $this->buildTree($partners);
        return $this->render('index', [
            'tableTreePartners' => $tableTreePartners,
            'isFavorite' => $isFavorite,

        ]);
    }

    public function actionGetSupplier($id) {
        return json_encode(SuppliersList::find()->where(['id' => $id])->asArray()->one());

    }
    public function actionDeleteSup()
    {
        $form_data = Yii::$app->request->get();
        $id = intval($form_data['id']);
        $this->findModel($id)->delete();
        return true;
    }
     public function actionGetInfoPay()
    {
        $form_data = Yii::$app->request->get();
        $invoices = '';
        if($form_data['id']){
            $invoices = ShippingRequest::getPartnerTotalInvoices($form_data['id']);

        }
    
        return $invoices;
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
     * Creates a new SuppliersList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $model = new SuppliersList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $admins = User::find()->where(['role'=>'admin'])->all();
            if(!empty($admins)){
                foreach ($admins as $key => $value) {
                   Notifications::setNotification($value->id,"Ստեղծվել է նոր Գործընկեր ".$model->name,'/warehouse/suppliers-list');
                }
            } 
            return $this->redirect(['index','isFavorite' => $isFavorite]);
        }

        return $this->render('create', [
            'model' => $model,
            'isFavorite' => $isFavorite,

        ]);
    }

    /**
     * Updates an existing SuppliersList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             $admins = User::find()->where(['role'=>'admin'])->all();
            if(!empty($admins)){
                foreach ($admins as $key => $value) {
                   Notifications::setNotification($value->id,"Փոփոխվել է Գործընկեր ".$model->name,'/warehouse/suppliers-list');
                }
            } 
            return $this->redirect(['view','isFavorite' => $isFavorite, 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'isFavorite' => $isFavorite,
        ]);
    }

    /**
     * Deletes an existing SuppliersList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $admins = User::find()->where(['role'=>'admin'])->all();
            if(!empty($admins)){
                foreach ($admins as $key => $value) {
                   Notifications::setNotification($value->id,"Ջնջվել է Գործընկեր ".$id,'/warehouse/suppliers-list');
                }
            } 
        return $this->redirect(['index']);
    }

    /**
     * Finds the SuppliersList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SuppliersList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SuppliersList::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}