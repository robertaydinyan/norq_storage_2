<?php

namespace app\modules\warehouse\controllers;

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
        if (Yii::$app->request->post()) {

            $form_data = Yii::$app->request->post();
            if(!isset($form_data['update_button'])) {
                $model = new SuppliersList();
                $model->name = $form_data['name'];
                if ($form_data['parent_id']) {
                    $model->parent_id = $form_data['parent_id'];
                }
                $model->save(false);
            } else {
                $model = SuppliersList::find()->where(['id'=>$form_data['id']])->one();
                $model->name = $form_data['name'];
                $model->save(false);
            }
            return $this->redirect(['index', 'lang' => \Yii::$app->language]);
        }
        $partners = SuppliersList::find()->asArray()->all();
        $tableTreePartners = $this->buildTree($partners);
        return $this->render('index', [
            'tableTreePartners' => $tableTreePartners,
        ]);
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
        $model = new SuppliersList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $admins = User::find()->where(['role'=>'admin'])->all();
            if(!empty($admins)){
                foreach ($admins as $key => $value) {
                   Notifications::setNotification($value->id,"Ստեղծվել է նոր Գործընկեր ".$model->name,'/warehouse/suppliers-list');
                }
            } 
            return $this->redirect(['index', 'lang' => \Yii::$app->language]);
        }

        return $this->render('create', [
            'model' => $model,
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             $admins = User::find()->where(['role'=>'admin'])->all();
            if(!empty($admins)){
                foreach ($admins as $key => $value) {
                   Notifications::setNotification($value->id,"Փոփոխվել է Գործընկեր ".$model->name,'/warehouse/suppliers-list');
                }
            } 
            return $this->redirect(['view', 'id' => $model->id, 'lang' => \Yii::$app->language]);
        }

        return $this->render('update', [
            'model' => $model,
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
        return $this->redirect(['index', 'lang' => \Yii::$app->language]);
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
