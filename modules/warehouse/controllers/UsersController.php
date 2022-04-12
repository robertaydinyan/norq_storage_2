<?php

namespace app\modules\warehouse\controllers;

use app\components\Url;
use app\models\User;
use app\models\UserSearch;
use app\modules\warehouse\models\Action;
use app\modules\warehouse\models\Complectation;
use app\modules\warehouse\models\Favorite;
use app\modules\warehouse\models\TableRowsCount;
use app\modules\warehouse\models\TableRowsStatus;
use app\modules\warehouse\models\UserAction;
use app\rbac\WarehouseRule;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StatusListController implements the CRUD actions for StatusList model.
 */
class UsersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }
    public function __construct($id, $module, $config = []) {
        parent::__construct($id, $module, $config);
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
    }

    /**
     * Lists all StatusList models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        TableRowsStatus::checkRows('User');
        $columns = TableRowsStatus::find()->where(['page_name' => 'User', 'userID' => Yii::$app->user->id, 'status' => 1])->orderBy('order')->all();
        $rows_count = TableRowsCount::find()->where(['page_name' => 'User', 'userID' => Yii::$app->user->id])->one();
        $users = User::find()->all();
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app
            ->request
            ->queryParams);
        $dataProvider->pagination->pageSize = $rows_count['count'];

        return $this->render('index', [
            'users' => $users,
            'isFavorite' => $isFavorite,
            'dataProvider' => $dataProvider,
            'columns' => $columns,
        ]);
    }

    public function actionEdit($id) {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $user = User::findOne(['id' => $id]);
        $controller_names = Action::find()->select('DISTINCT `controller_name`')->all();
        return $this->render('edit', [
            'user' => $user,
            'controller_names' => $controller_names,
            'isFavorite' => $isFavorite,
        ]);
    }

    public function actionChangePermission() {
        $request = Yii::$app->request;
        $actionID = $request->post('actionID');
        $userID = $request->post('userID');
        $status = $request->post('status');
        if ($status) {
            $action = new UserAction();
            $action->user_id = $userID;
            $action->action_id = $actionID;
            return $action->save(false);
        } else {
            return UserAction::deleteAll(['action_id' => $actionID, 'user_id' => $userID]);
        }
    }

    public function actionCreate() {
        $lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;
        $user = new User();
        $request = Yii::$app->request;
        if ($request->isPost) {
            $user->load($request->post(), 'User');
            $user->save(false);

            $action = new UserAction();
            $action->user_id = $user->id;
            $action->action_id = 125;
            $action->save(false);

            return $this->redirect(['users/index','isFavorite' => $isFavorite, 'lang' => $lang]);
        }
        return $this->render('create', [
            'user' => $user,
            'isFavorite' => $isFavorite,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['users/index', 'lang' => \Yii::$app->language]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}