<?php

namespace app\controllers;

use Carbon\Carbon;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\web\Controller;
use yii\web\Request;

class AnalyticsController extends Controller
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
    public function actionIndex()
    {
        return $this->render('index', compact('dataSets'));
    }

    /**
     * @param Request $request
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionLoadConnections(Request $request)
    {
        $sql = "SELECT COUNT(id) AS count, MONTH(create_at) AS month FROM `f_deal` WHERE is_active = 1 ";

        if (!empty($request->post('month'))) {
            $sql .= " AND MONTH(create_at) = {$request->post('month')} ";
        }

        $sql .= "GROUP BY YEAR(create_at), MONTH(create_at)";

        $dataSets = \Yii::$app->db->createCommand($sql)->queryAll();
        $labels = [];
        $data = [];

        if (!empty($dataSets)) {
            Carbon::setLocale('hy');

            foreach ($dataSets as $key => $sets) {
                $labels[] = StringHelper::mb_ucfirst(Carbon::createFromFormat('m', $sets['month'])->monthName);
                $data[] = $sets['count'];
            }
        }

        return Json::encode(['labels' => $labels, 'data' => $data]);
    }
}