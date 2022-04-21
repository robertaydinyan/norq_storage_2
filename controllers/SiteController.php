<?php

namespace app\controllers;

use app\components\Helper;
use app\modules\warehouse\models\SiteSettings;
use app\modules\warehouse\models\TableRowsCount;
use app\modules\warehouse\models\TableRowsStatus;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Notifications;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dd  = New Helper();

        echo '<pre>', var_dump($dd->mathPriceMonth(10000, null, null, '2020-12-07', '2021-02-25' ));die;
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if ($this->request->get('key') != 'kCWkz0mAW4uNgxbm') die();

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionNotifications()
    {
       return Notifications::updateNotificationStatus(intval($_POST['id']));
    }

    public function actionNotificationsUpdate()
    {
        return $this->renderAjax('notifications');
    }

    public function actionGetLastFormHtml() {
        return $this->render('lastForm');
    }
    public function actionGetTableRows() {
        $request = $this->request;
        if($request->isGet) {
            $pageName = $request->get('page');
            $type = $request->get('type') ?: null;
            TableRowsStatus::checkRows($pageName, $type);
            $rows_count = TableRowsCount::find()->where(['page_name' => $pageName, 'userID' => Yii::$app->user->id])->one();
            $columnsActive = TableRowsStatus::find()->where(['page_name' => $pageName, 'userID' => Yii::$app->user->id, 'status' => 1, 'type' => $type])->orderBy('order')->all();
            $columnsPassive = TableRowsStatus::find()->where(['page_name' => $pageName, 'userID' => Yii::$app->user->id, 'status' => 0, 'type' => $type])->orderBy('order')->all();

            return $this->renderAjax('/modal/modal-table', [
                'page' => $pageName,
                'columnsActive' => $columnsActive,
                'columnsPassive' => $columnsPassive,
                'rows_count' => $rows_count
            ]);
        }
    }

    public function actionChangeSiteStatus() {
        $request = $this->request;
        $isAdmin = Yii::$app->user->identity->role == "admin";
        if ($request->isPost && $isAdmin) {
            $status = $request->post('status');
            $userID = $request->post('userID');
            if ($userID) {
                $s = User::find()->where(['id' => $userID])->one();
                $s->blocked = $status;
            } else {
                $s = SiteSettings::find()->where(['name' => 'page-status'])->one();
                $s->value = $status;
            }
            $s->save();
            die();
        }
        return $this->redirect('/site/error');
    }

    public function actionLastForm() {
        return $this->renderAjax('lastForm');
    }
}