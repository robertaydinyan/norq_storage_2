<?php

namespace app\modules\warehouse\controllers;

use app\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * StatusListController implements the CRUD actions for StatusList model.
 */
class AdminController extends Controller
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
    public function actionActions() {
//        return $this->render()
    }

}