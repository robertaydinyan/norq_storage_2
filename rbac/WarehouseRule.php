<?php

namespace app\rbac;

use app\modules\warehouse\models\Action;
use app\modules\warehouse\models\ActionDep;
use app\modules\warehouse\models\UserAction;
use Yii;

/**
 * Class UserRule
 *
 * @package app\rbac\rules
 */
class WarehouseRule {
    static function can($controller = '', $action = '', $params = []) {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        if (Yii::$app->user->identity->role == "admin") {
            return true;
        }
        $controller = $controller ?: Yii::$app->controller->id;
        $action = $action ?: Yii::$app->controller->action->id;
        $userID = Yii::$app->user->id;
        if (!($controller == 'site' && $action == "error")) {
            $access = WarehouseRule::hasAccess($controller, $action, $userID);
            if ($access == 0) {
                $depID = ActionDep::find()->where('action_name = "' . $action . '" AND controller_name = "' . $controller . '"')->one()->depID;
                if ($depID && WarehouseRule::hasAccessBYID($depID, $userID) != 0) {
                    return true;
                }
                return false;
            }
        }
        return true;
    }

    private static function hasAccess($controller, $action, $userID) {
        return UserAction::find()
            ->leftJoin('actions', '`user_actions`.`action_id` = actions.id')
            ->where('actions.action_name = "' . $action . '" AND actions.controller_name = "' . $controller . '" AND user_actions.user_id = ' . $userID)
            ->orderBy('user_actions.id')
            ->one();
    }

    private static function hasAccessBYID($id, $userID) {
        return UserAction::find()
            ->leftJoin('actions', '`user_actions`.`action_id` = actions.id')
            ->where('actions.id = ' . $id . ' AND user_actions.user_id = ' . $userID)
            ->orderBy('user_actions.id')
            ->count();
    }
}