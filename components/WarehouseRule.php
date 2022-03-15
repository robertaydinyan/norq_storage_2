<?php

namespace app\components;

use app\modules\warehouse\models\Action;
use Yii;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;

class WarehouseRule extends BaseObject implements UrlRuleInterface
{
    public function parseRequest($manager, $request)
    {


        return false;
    }

    public function createUrl($manager, $route, $params)
    {
        return false;

    }
}