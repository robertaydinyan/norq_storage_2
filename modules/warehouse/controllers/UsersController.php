<?php

namespace app\modules\warehouse\controllers;

use app\models\User;
use app\modules\warehouse\models\Action;
use app\modules\warehouse\models\UserAction;
use Yii;
use app\modules\warehouse\models\StatusList;
use app\modules\warehouse\models\SearchStatusList;
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
                'actions' => [
                    'delete' => ['POST'],
                ],
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
        $users = User::find()->all();
        return $this->render('index', [
            'users' => $users
        ]);
    }

    public function actionEdit($id) {
        $user = User::findOne(['id' => $id]);
        $actions = Action::find()->all();
        return $this->render('edit', [
            'user' => $user,
            'actions' => $actions,
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
}