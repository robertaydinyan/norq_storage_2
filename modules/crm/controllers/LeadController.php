<?php

namespace app\modules\crm\controllers;

use app\modules\crm\models\CrmFieldType;
use app\modules\crm\models\CrmFieldValue;
use app\modules\crm\models\CrmSection;
use app\modules\crm\models\CrmStatus;
use app\modules\crm\models\CrmMenu;
use app\modules\crm\models\CrmCustomFields;
use app\modules\crm\models\CrmCustomList;
use Yii;
use app\modules\crm\models\Lead;
use app\modules\crm\models\LeadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LeadController implements the CRUD actions for Lead model.
 */
class LeadController extends Controller
{
    /**
     * @var int
     */
    private $menu_id = 1;

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
     * Lists all Lead models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Lead();
        $searchModel = new LeadSearch();
        $dataProvider = $searchModel->search_new();

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionKanban()
    {
        $leadData = new Lead();
        $leads = $leadData->kanbanData();

        return $this->render('kanban', ['leads' => $leads]);
    }

    /**
     * @return string
     */
    public function actionCalendar(){
        return $this->render('calendar');
    }

    public function actionCalendarList(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(\Yii::$app->request->isAjax){
            $leadData = new Lead();
            //return Ride::getRideListForCalendar();
            return $leadData->CalendarData();
        }
    }



    /**
     * Displays a single Lead model.
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
     * Creates a new Lead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lead();

        $sections = CrmSection::find()->where(['menu_id'=>$this->menu_id])->all();
        $statuses_obj = CrmStatus::find()->where(['menu_id'=>$this->menu_id])->all();
        $statuses = [];
        if(!empty($statuses_obj)) {
            foreach ($statuses_obj as $status => $val) {
                $statuses[$val->id] = $val->name;
            }
        }
        $input_types = CrmFieldType::find()->all();

        // Show popup
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'statuses' => $statuses,
                'input_types' => $input_types,
                'model' => $model,
                'sections' => $sections
            ]);
        } else {

            if (Yii::$app->request->post()) {
                $post = Yii::$app->request->post();
                $model->name = $post['Lead']['name'];
                $model->status_id = $post['Lead']['status_id'];
                $changeItems = Lead::find()->where(['>=', 'ordering', 1])->andWhere(['status_id' => $post['Lead']['status_id']])->all();

                if (!empty($changeItems)) {
                    foreach ($changeItems as $changeItem => $itemVal){
                        $itemVal->ordering = $itemVal->ordering + 1;
                        $itemVal->save();
                    }
                }

                if ($model->save()) {
                    if(!empty($post['Fields'])) {
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
                'statuses' => $statuses,
                'input_types' => $input_types,
                'model' => $model,
                'sections' => $sections
            ]);
        }
    }

    /**
     * @return false|string
     */
    public function actionCreateSection()
    {
        $post = Yii::$app->request->post();
        $section = new CrmSection();
        $section->menu_id = $this->menu_id;
        $section->name = $post['value'];
        $section->save();
        return json_encode(['result'=>$section->id]);
    }

    /**
     * @return false|string
     */
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

    public function actionAjaxCreate(){
        if (Yii::$app->request->post()) {
            $model = new Lead();
            $post = Yii::$app->request->post();
            $model->name = $post['title'];
            $model->status_id = $post['status_id'];
            $changeItems = lead::find()->where(['>=','ordering',1])->andWhere(['status_id'=>$post['status_id']])->all();
            foreach ($changeItems as $changeItem => $itemVal){
                $itemVal->ordering = $itemVal->ordering + 1;
                $itemVal->save();
            }
            return $model->save();
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
    public function actionUpdateStatus()
    {

        $post = Yii::$app->request->post();
        $id = $post['id'];
        $status_id = $post['status_id'];
        $model = $this->findModel($id);
        $model->status_id = $status_id;
        $res = $model->save();
        $ids = $post['ids'];

        for ($i=0; $i< count($ids); $i++){
            $lead = Lead::findOne(['id'=>$ids[$i]]);
            $lead->ordering = $i+1;
            $lead->save();
        }
        return $res;
    }
    public function actionAddStatus()
    {

        $post = Yii::$app->request->post();
        $ids = $post['ids'];
        $status_data = $post['status_data'];
        if(!empty($status_data['title'])) {
            $status = new CrmStatus();
            $status->ordering = $status_data['position'];
            $status->name = $status_data['title'];
            $status->menu_id = $this->menu_id;
            $status->color = '#eeeeee';
            $status->save();

            for ($i = 0; $i < count($ids); $i++) {

                if (strpos($ids[$i], 'new') === false) {
                    $status_new = CrmStatus::findOne(['id' => $ids[$i]]);
                    $status_new->ordering = $i + 1;
                    $status_new->save();
                } else {
                    $status_new = CrmStatus::findOne(['id' => $status->id]);
                    $status_new->ordering = $i + 1;
                    $status_new->save();
                }
            }
        }
        return true;
    }
    public function actionDeleteLeads()
    {

        $post = Yii::$app->request->post();

        $ids = $post['ids'];
        if(!empty($ids)) {
            Lead::deleteAll(['id' => $ids]);
        }
        return true;
    }
    public function actionUpdateOrdering()
    {
        $post = Yii::$app->request->post();
        $ids = $post['ids'];
        for ($i=0; $i< count($ids); $i++){
            $model = CrmStatus::findOne(['id'=>$ids[$i]]);
            $model->ordering = $i+1;
            $model->save();
        }
        return true;
    }

    public function actionUpdateParams()
    {
        $post = Yii::$app->request->post();
        $id = $post['status_id'];

        $model = CrmStatus::findOne(['id'=>$id]);
        if(isset($post['color'])){
            $model->color = $post['color'];
        }
        if(isset($post['title'])){
            $model->name = $post['title'];
        }
        $res = $model->save();
        return $res;
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
     * Updates an existing Lead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $sections = CrmSection::find()->where(['menu_id' => $this->menu_id])->all();
        $input_types = CrmFieldType::find()->all();
        $statuses_obj = CrmStatus::find()->where(['menu_id' => $this->menu_id])->all();
        $statuses = [];

        if(!empty($statuses_obj)) {
            foreach ($statuses_obj as $status => $val) {
                $statuses[$val->id] = $val->name;
            }
        }

        $field_values = CrmFieldValue::find()->where(['column_id' => $id])->all();
        $fields = [];

        if (!empty($field_values)) {
            foreach ($field_values as $field=> $value ){
                $fields[$value->field_id] = $value->value;
            }
        }

        // Show popup
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'field_values' => $fields,
                'statuses' => $statuses,
                'sections' => $sections,
                'input_types' => $input_types,
                'model' => $model,
            ]);
        } else {
            if (Yii::$app->request->post()) {
                $post = Yii::$app->request->post();
                $model->name = $post['Lead']['name'];
                $model->status_id = $post['Lead']['status_id'];

                if ($model->save()) {
                    if (!empty($post['Fields'])) {
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
                }

                return $this->redirect(['index']);
            }

            return $this->render('update', [
                'field_values' => $fields,
                'statuses' => $statuses,
                'sections' => $sections,
                'input_types' => $input_types,
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Lead model.
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
     * Finds the Lead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lead::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
