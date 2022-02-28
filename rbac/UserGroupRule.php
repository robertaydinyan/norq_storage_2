<?php

namespace app\rbac;

use Yii;
use yii\rbac\Rule;

/**
 * Class UserGroupRule
 *
 * @package app\rbac\rules
 */
class UserGroupRule extends Rule
{

    /**
     * @inheritdoc
     */
    public $name = 'userGroup';

    /**
     * @param int|string $user
     * @param yii\rbac\Item $item
     * @param array $params
     * @return bool
     */
    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            $group = Yii::$app->user->identity->role;
            if ($item->name === 'admin') {
                return $group == 'admin';
            } elseif ($item->name === 'manager') {
                return $group == 'admin' || $group == 'manager';
            } elseif ($item->name === 'operator') {
                return $group == 'admin' || $group == 'operator';
            } elseif ($item->name === 'terminal') {
                return $group == 'admin' || $group == 'terminal';
            }
        }
        return false;
    }
}