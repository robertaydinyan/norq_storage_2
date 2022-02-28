<?php

namespace app\controllers;

use app\modules\billing\models\Cities;
use app\modules\billing\models\Regions;
use Carbon\Carbon;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\web\Controller;
use yii\web\Request;

class LocationController extends Controller
{

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
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionGetRegionsByCountryMulti(Request $request)
    {
        if ($request->isAjax && !is_null($request->post('id'))) {

            $selectedList = [];
            if (!empty($model->city)) {
                foreach ($model->city as $city) {
                    $selectedList[$city->id] = $city->name;
                }
            }

            $optionsList = Cities::find()
                ->select(['cities.id', 'cities.name', 'region_id'])
                ->where(['IN', 'region_id', $request->post('id')])
                ->all();

            # Group cities by region
            $cityArray = ArrayHelper::map($optionsList, 'id', 'name', 'region_id');

            $options = [];
            if (!empty($cityArray)) {

                foreach ($cityArray as $region => $option) {
                    $cities = [];

                    foreach ($option as $id => $text) {
                        $cities[] = ['id' => $id, 'text' => $text];
                    }

                    $regionName = Regions::find()->select(['name'])->where(['id' => $region])->one();

                    $options[] = ['text' => $regionName->name, 'children' => $cities];
                }
            }
            return Json::encode(['optionsList' => $options, 'selected' => $selectedList]);

        }

        return null;
    }
}