<?php


namespace app\modules\billing\controllers;


use app\models\User;
use app\modules\billing\models\DealPaymentLog;
use app\modules\billing\models\query\BillingQuery;
use app\modules\billing\models\TableSearch;
use app\modules\billing\models\TableSettings;
use app\modules\crm\models\Company;
use app\modules\crm\models\Contact;
use app\modules\crm\models\ContactSearch;
use app\modules\crm\models\Deal;
use app\modules\crm\models\DealSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;

class ClientController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => 'app\components\CAccessRule',
                ],
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => [
                            '?',
                        ],
                    ],
                    // Role for only not guests
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ],

                ],
            ],
        ];
    }
    public function actionPage()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $page = intval($post['page']);
            $sort = 'none';
            $column = '';

            if(isset($post['sort'])) {
                $sort = $post['sort'];
            }
            if(isset($post['column'])) {
                $column = $post['column'];
            }
            if(isset($post['dataSearch'])) {
                $dataSearch = $post['dataSearch'];
            } else {
                $dataSearch = '';
            }
            $searchModel = new DealSearch();

            // new example for table
            $dataProvider = $searchModel->search_new('/billing/client', $page, $sort, $column, $dataSearch,true, true);
            return Json::encode($dataProvider);
        }
    }
    public function actionIndex() {
      $searchModel = new DealSearch();
      $dataProvider = $searchModel->search_new('/billing/client',null, null, null, null, true, true);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        $deal = Deal::findOne($id);
        $contact = [];
        $company = [];

        if(intval($deal->contact_id)){
            $contact = Contact::findOne($deal->contact_id);
        } else if(intval($deal->company_id)){
            $company = Company::findOne($deal->company_id);
        }

        $deals =  Deal::getDealsByClient($contact, $company);
        return $this->renderAjax('detail_view', [
            'contact' => $contact,
            'company' => $company,
            'deals' => $deals
        ]);
    }

    /**
     * @return array
     * @throws \yii\db\Exception
     */
    public function actionUpdateTable() {
        if(Yii::$app->request->isAjax) {
            $model = TableSettings::find()->where(['user_id'=>Yii::$app->user->id,'page'=>'/billing/client'])->one();
            if(!empty($model)){
                if(isset($_POST['data']['str'])) {
                    $model->column_order = $_POST['data']['str'];
                }
                if(isset($_POST['data']['str_status'])) {
                    $model->column_status = $_POST['data']['str_status'];
                }
                if(isset($_POST['data']['count_show'])) {
                    $model->count_show = $_POST['data']['count_show'];
                }
                if(isset($_POST['data']['pin'])) {
                    $model->pined = $_POST['data']['pin'];
                }
                return $model->save();
            } else {
                $model = new TableSettings();
                $model->page = '/billing/client';
                if(isset($_POST['data']['str'])) {
                    $model->column_order = $_POST['data']['str'];
                }
                if(isset($_POST['data']['count_show'])) {
                    $model->count_show = $_POST['data']['count_show'];
                }
                if(isset($_POST['data']['str_status'])) {
                    $model->column_status = $_POST['data']['str_status'];
                }
                if(isset($_POST['data']['pin'])) {
                    $model->pined = $_POST['data']['pin'];
                }
                $model->user_id = Yii::$app->user->id;
                return  $model->save();
            }
        }
    }
    /**
     * @return array
     * @throws \yii\db\Exception
     */
    public function actionUpdateSearch() {
        if(Yii::$app->request->isAjax) {

            $post = Yii::$app->request->post();
            $active = intval($post['data']['active']);
            $str = $post['data']['str_search'];
            $page = $post['data']['page'];

            if($active == 1) {
                $model = TableSettings::find()->where(['user_id'=>Yii::$app->user->id,'page'=>'/billing/client'])->one();
                if(!empty($model)){
                    $model->column_search = $str;
                    return $model->save();

                } else {
                    $model = new TableSettings();
                    $model->column_search = $str;
                    return $model->save();
                }
            } else {
                if($active != -1) {
                    $model = TableSearch::find()->where(['id' => $active])->one();
                    $model->page = $page;
                    $model->column_search = $str;
                    return $model->save();
                } else {
                    $model = new TableSearch();
                    $model->page = $page;
                    $model->name = $post['data']['name'];
                    $model->user_id = Yii::$app->user->id;
                    $model->column_search = $str;
                    return $model->save();
                }
            }
        }
    }
}