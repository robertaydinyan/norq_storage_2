<?php
namespace app\components;

use yii\filters\AccessRule;


class CAccessRule extends AccessRule
{
    /**
     * @param \yii\base\Action $action the action
     * @return bool whether the rule applies to the action
     */
    protected function matchAction($action)
    {
        return !empty($this->actions) && in_array($action->id, $this->actions, true);
    }

    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }
        foreach ($this->roles as $role) {
            if ($role === '?') {
                if ($user->getIsGuest()) {
                    return true;
                }
            } elseif ($role === '@') {
                if (!$user->getIsGuest()) {
                    return true;
                }
                // Check if the user is logged in, and the roles match
            } elseif (!$user->getIsGuest() && $role === $user->identity->role) {
                return true;
            }
        }

        return false;
    }
}
