<?php

namespace app\controllers;


use app\components\Url;
use app\models\Notifications;
use app\modules\warehouse\models\Favorite;
use app\rbac\WarehouseRule;
use Yii;
use yii\web\Controller;

class NotificationsController extends Controller {
    public function actionIndex() {
        $count_per_page = 10;
        $page = Yii::$app->request->get('page');
        $page = $page ? $page : 1;
        $notifications = Notifications::find()->where(['user_id' => Yii::$app->user->id])->orderBy(['id' => SORT_DESC])->offset(($page - 1) * $count_per_page)->limit($count_per_page)->all();
        $nc = Notifications::find()->where(['user_id' => Yii::$app->user->id])->count();
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link_no_lang' => WarehouseRule::removeLangFromLink(URL::current())])->count() == 1;

        return $this->render('index', [
            'notifications' => $notifications,
            'nc' => $nc,
            'page' => $page,
            'count_per_page' => $count_per_page,
            'isFavorite' => $isFavorite,
        ]);
    }
}