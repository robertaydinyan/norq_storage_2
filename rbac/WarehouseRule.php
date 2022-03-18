<?php

namespace app\rbac;

use app\components\Url;
use app\modules\warehouse\models\Action;
use app\modules\warehouse\models\ActionDep;
use app\modules\warehouse\models\UserAction;
use app\modules\warehouse\models\UserHistory;
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
        $controller = $controller ?: Yii::$app->controller->id;
        $action = $action ?: Yii::$app->controller->action->id;
        $userID = Yii::$app->user->id;
        if (!($controller == 'site' && $action == "error") && Yii::$app->user->identity->role != "admin") {
            $access = WarehouseRule::hasAccess($controller, $action, $userID);
            if ($access == 0) {
                $depID = ActionDep::find()->where('action_name = "' . $action . '" AND controller_name = "' . $controller . '"')->one()->depID;
                if ($depID && WarehouseRule::hasAccessBYID($depID, $userID) != 0) {
                    return WarehouseRule::continue();
                }
                return false;
            }
        }
        return WarehouseRule::continue();
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

    private static function continue() {
        return true;
    }

    public static function savePage($title) {
        $user_id = Yii::$app->user->id;
        $link = URL::current();
        if (explode('?', $link)[0] == "/site/error") return 0;
        $st = preg_replace('/lang=[a-zA-Z]+&/', '', $link);
        if ($st == $link) {
            $st = preg_replace('/lang=[a-zA-Z]+/', '', $link);
        }
        if ($st == $link) {
            $st = preg_replace('/lang=/', '', $link);
        }
        if (substr($st, -1) == "&" || substr($st, -1) == "?") {
            $st = substr($st, 0, -1);
        }

        $time = strtotime("now");
        $h = UserHistory::find()->where(['link' => $st, 'user_id' => $user_id])->one();
        if (!$h) {
            $h = new UserHistory();
            $h->user_id = $user_id;
            $h->link = $st;
            $h->title = $title;
        }
        $h->time = $time;
        $h->save();
    }
}