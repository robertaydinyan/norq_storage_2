<?php

namespace app\modules\warehouse\controllers;

use app\components\Url;
use app\modules\warehouse\models\Favorite;
use yii\web\Controller;

/**
 * Default controller for the `warehouse` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;


        return $this->render('index',[
            'isFavorite' => $isFavorite,
        ]);
    }
}
