<?php

namespace app\modules\crm\controllers;

use app\modules\crm\models\CrmCustomFields;
use app\modules\crm\models\CrmCustomList;
use app\modules\crm\models\CrmFieldType;
use app\modules\crm\models\CrmFieldValue;
use app\modules\crm\models\CrmSection;
use Yii;
use app\modules\crm\models\Product;
use app\modules\crm\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    private $menu_id = 4;
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
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search_new();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $sections = CrmSection::find()->where(['menu_id'=>$this->menu_id])->all();
        $input_types = CrmFieldType::find()->all();

        // Show popup
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'input_types' => $input_types,
                'model' => $model,
                'sections' => $sections
            ]);
        } else {
            if (Yii::$app->request->post()) {
                $post = Yii::$app->request->post();
                $model->name = $post['Product']['name'];
                $model->eq_or_sup = $post['Product']['eq_or_sup'];
                $model->base_amount = $post['Product']['base_amount'];
                $model->currency_id = $post['Product']['currency_id'];
                $model->count = $post['Product']['count'];
                $model->unit_id = $post['Product']['unit_id'];
                $model->warehouse_id = $post['Product']['warehouse_id'];

                if ($model->save()) {
                    if (!empty($post['Fields'])) {
                        foreach ($post['Fields'] as $field => $value) {
                            $Cfield = new CrmFieldValue();
                            $Cfield->field_id = $field;
                            $Cfield->value = $value;
                            $Cfield->column_id = $model->id;
                            $Cfield->save();
                        }
                    }

                    return $this->redirect(['index']);
                }
            }

            return $this->render('create', [
                'input_types' => $input_types,
                'model' => $model,
                'sections' => $sections
            ]);
        }
    }
    public function actionCreateSection()
    {
        $post = Yii::$app->request->post();
        $section = new CrmSection();
        $section->menu_id = $this->menu_id;
        $section->name = $post['value'];
        $section->save();
        return json_encode(['result'=>$section->id]);
    }
    public function actionAddField()
    {
        $post = Yii::$app->request->post();
        $field = new CrmCustomFields();
        $field->section_id = $post['section_id'];
        $field->field_type_id = $post['field_type_id'];
        $field->name = 'ccf_'.time();
        $field->label = $post['value'];
        $field->status = 1;
        $field->required = intval($post['required']);
        $field->save();
        if($field->field_type_id == 2 && $post['options'] != ''){
            $options = explode(',',$post['options']);
            $new_options = [];
            for ($i=0; $i<count($options); $i++){
                if($options[$i]){
                    $option = new CrmCustomList();
                    $option->custom_field_id = $field->id;
                    $option->value = $options[$i];
                    $option->save();
                    $new_options[$option->id] = $option->value;
                }
            }
            return json_encode(['options'=>$new_options,'name'=>$field->name,'id'=>$field->id]);
        } else {
            return json_encode(['name'=>$field->name,'id'=>$field->id]);
        }

    }

    public function actionUpdateField()
    {
        $post = Yii::$app->request->post();
        $field = CrmCustomFields::find()->where(['id'=>intval($post['field_id'])])->one();

        $field->label = $post['value'];
        $field->status = 1;
        $field->required = intval($post['required']);
        $field->save();
        if($field->field_type_id == 2 && $post['options'] != ''){
            $options = explode(',',$post['options']);
            $new_options = [];
            CrmCustomList::deleteAll(['custom_field_id'=>intval($post['field_id'])]);
            for ($i=0; $i<count($options); $i++){
                if($options[$i]){
                    $option = new CrmCustomList();
                    $option->custom_field_id = $field->id;
                    $option->value = $options[$i];
                    $option->save();
                    $new_options[$option->id] = $option->value;
                }
            }
            return json_encode(['options'=>$new_options,'name'=>$field->name,'id'=>$field->id]);
        } else {
            return json_encode(['name'=>$field->name,'id'=>$field->id]);
        }
        return true;

    }
    public function actionUpdateSection()
    {
        $post = Yii::$app->request->post();
        $section = CrmSection::findOne(['id'=>$post['id']]);
        $section->name = $post['value'];
        $section->save();
        return json_encode(['result'=>$section->id]);
    }

    public function actionDeleteSection()
    {
        $post = Yii::$app->request->post();
        return CrmSection::findOne(['id' =>intval($post['id'])])->delete();
    }
    public function actionDeleteField()
    {
        $post = Yii::$app->request->post();
        CrmCustomFields::findOne(['id' =>intval($post['id'])])->delete();
        if(intval($post['type']) == 2) {
            CrmCustomList::findOne(['custom_field_id' => intval($post['id'])])->delete();
        }
        return true;
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
        $model = $this->findModel($id);
        $sections = CrmSection::find()->where(['menu_id'=>$this->menu_id])->all();
        $input_types = CrmFieldType::find()->all();
        $field_values = CrmFieldValue::find()->where(['column_id'=>$id])->all();
        $fields = [];
        foreach ($field_values as $field=> $value ){
            $fields[$value->field_id] = $value->value;
        }

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $model->name = $post['Product']['name'];
            $model->save();
            if(!empty($post['Fields'])) {
                foreach ($post['Fields'] as $field => $value) {
                    $Cfield = CrmFieldValue::find()->where(['column_id' => $id, 'field_id' => $field])->one();
                    if ($Cfield) {
                        $Cfield->value = $value;
                        $Cfield->save();
                    } else {
                        $Cfield = new CrmFieldValue();
                        $Cfield->field_id = $field;
                        $Cfield->value = $value;
                        $Cfield->column_id = $model->id;
                        $Cfield->save();
                    }
                }
            }
            return $this->redirect(['index']);
        }

        return $this->renderAjax('update', [
            'field_values'=>$fields,
            'sections'=>$sections,
            'input_types'=>$input_types,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
