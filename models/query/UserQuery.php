<?php

namespace app\models\query;

use app\models\User;
use app\modules\crm\models\Cashier;
use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{

    /**
     * Active user
     *
     * @return UserQuery
     */
    public function active() {
        return $this->andWhere(['status' => User::STATUS_ACTIVE]);
    }

    /**
     * Super admin
     *
     * @return UserQuery
     */
    public function roleAdmin() {
        return $this->andWhere(['role' => User::ROLE_ADMIN]);
    }

    /**
     * Manager
     *
     * @return UserQuery
     */
    public function roleManager() {
        return $this->andWhere(['role' => User::ROLE_MANAGER]);
    }

    /**
     * Operator
     *
     * @return UserQuery
     */
    public function roleOperator() {
        return $this->andWhere(['role' => User::ROLE_OPERATOR]);
    }

    /**
     * User
     *
     * @return UserQuery
     */
    public function roleUser() {
        return $this->andWhere(['role' => User::ROLE_USER]);
    }

    /**
     * @param $usernameOrEmail
     * @return UserQuery
     */
    public function whereUsernameOrEmail($usernameOrEmail) {
        return filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)
            ? $this->whereEmail($usernameOrEmail)
            : $this->whereUsername($usernameOrEmail);
    }

    /**
     * @param $email
     * @return UserQuery
     */
    public function whereEmail($email) {
        return $this->andWhere(['email' => $email]);
    }

    /**
     * @param $username
     * @return UserQuery
     */
    public function whereUsername($username) {
        return $this->andWhere(['username' => $username]);
    }

    /**
     * @param $id
     * @return UserQuery
     */
    public function whereId($id) {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @param $id
     * @return UserQuery
     */
    public function whereNotId($id) {
        return $this->andWhere(['<>', 'id', $id]);
    }

    /**
     * @param $ids
     * @return UserQuery
     */
    public function availableOperatorsForCashier($ids) {
        return $this->andWhere(['NOT IN', 'id', $ids]);
    }

    /**
     * @param $ids
     * @return UserQuery
     */
    public function busyOperatorsForCashier($ids) {
        return $this->andWhere(['IN', 'id', $ids]);
    }

}