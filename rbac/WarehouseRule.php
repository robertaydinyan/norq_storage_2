<?php

namespace app\rbac;

use app\modules\warehouse\models\Action;
use app\modules\warehouse\models\UserAction;
use Yii;

/**
 * Class UserRule
 *
 * @package app\rbac\rules
 */
class WarehouseRule {
    static function can($controller = '', $action = '', $params = []) {
        $controller = $controller ?: Yii::$app->controller->id;
        $action = $action ?: Yii::$app->controller->action->id;
        if (!($controller == 'site' && $action == "error")) {
            $access = UserAction::find()
                ->leftJoin('actions', '`user_actions`.`action_id` = actions.id')
                ->where('actions.action_name = "' . $action . '" AND actions.controller_name = "' . $controller . '"')
                ->orderBy('user_actions.id')
                ->count();
            if ($access == 0) {
                return false;
            }
        }
        return true;
    }
}