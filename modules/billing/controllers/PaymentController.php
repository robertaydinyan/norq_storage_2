<?php


namespace app\modules\billing\controllers;


use app\models\User;
use app\modules\billing\models\DealPaymentLog;
use app\modules\billing\models\TableSearch;
use app\modules\billing\models\TableSettings;
use app\modules\crm\models\Cashier;
use app\modules\crm\models\Company;
use app\modules\crm\models\Contact;
use app\modules\crm\models\Deal;
use app\modules\crm\models\DealSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;

class PaymentController extends Controller
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

    /**
     * @return string
     */
    public function actionIndex() {
        $searchModel = new DealSearch();
        $dataProvider = $searchModel->search_new('/billing/payment',null, null, null, null, true, false, true);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
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
            $dataProvider = $searchModel->search_new('/billing/payment', $page, $sort, $column, $dataSearch,true, false, true);
            return Json::encode($dataProvider);
        }
    }
    public function actionPay() {

        if(Yii::$app->request->isAjax) {
            $payment = Yii::$app->request->post();
            if(!empty($payment)) {
                $cashier = Cashier::findOne($payment['operator_id']);

                $payment_log = new DealPaymentLog();
                $payment_log->deal_id = $payment['id'];
                $payment_log->price = $payment['price'];
                $payment_log->operator_id = $payment['operator_id'];
                $payment_log->status = 0;
                $payment_log->create_at = date("Y-m-d H:i:s");
                $payment_log->update_at = $cashier->virtual == Cashier::NOT_VIRTUAL ? date("Y-m-d H:i:s") : null;
                $payment_log->payer = $cashier->virtual == Cashier::NOT_VIRTUAL ? $payment['operator_id'] : null;

                    if($payment_log->save()){
                     return   Json::encode(['success' => true]);

                    }
                /* deal payment log */
//                $paymentLog = DealPaymentLog::groupedPaymentLogById($payment_log->id);
//
//                return $this->renderAjax('_log_ajax', [
//                    'paymentLog' => $paymentLog
//                ]);
            }
        }
    }
    public function actionView($id) {


        $dealsInfo = Deal::find()->where(['name' => $id])->all();
        $ids = [];
        $last_id = 0;
        foreach ($dealsInfo as $info){
            if($info->start_deal == 1){
                $deal = $info;
            }
          $last_id = ($last_id < $info->id) ? $info->id : $last_id;
            $ids[] = $info->id;
        }

        /* deal payment log */
        $paymentLog = DealPaymentLog::groupedDealPaymentLog($ids, $last_id);

        /* deal client info */

        $client = [];
        if(intval($deal->contact_id)){
            $client = Contact::findOne($deal->contact_id);
        } else if(intval($deal->company_id)){
            $client = Company::findOne($deal->company_id);
        }

        return $this->renderAjax('view', [
            'client' => $client,
            'deal' => $deal,
            'last_id' => $last_id,
            'paymentLog' => $paymentLog

        ]);
    }
    /**
     * @return array
     * @throws \yii\db\Exception
     */
    public function actionUpdateTable() {
        if(Yii::$app->request->isAjax) {
            $model = TableSettings::find()->where(['user_id'=>Yii::$app->user->id,'page'=>'/billing/payment'])->one();
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
                $model->page = '/billing/payment';
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
                $model = TableSettings::find()->where(['user_id'=>Yii::$app->user->id,'page'=>'/billing/payment'])->one();
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