<?php

namespace app\modules\rbac\helpers;

use Yii;

class PermissionHelpers
{

    /**
     * Example:
     * 'matchCallback' => function($rule, $action) {
     *      return PermissionHelpers::requireAdmin();
     * }
     *
     * @return bool
     */
    public static function requireAdmin() {

        if(Yii::$app->user->identity->role == 'admin')
        {
            return true;
        }
        else return false;
    }
}