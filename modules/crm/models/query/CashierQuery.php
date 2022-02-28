<?php


namespace app\modules\crm\models\query;


use app\modules\crm\models\Cashier;
use yii\db\ActiveQuery;

class CashierQuery extends ActiveQuery
{

    /**
     * @param $id
     * @return CashierQuery
     */
    public function getByOperatorId($id) {
        return $this->joinWith('operator')
            ->andWhere(['f_cashier_operator.operator_id' => $id]);
    }

    /**
     * @return CashierQuery
     */
    public function active() {
        return $this->andWhere(['is_active' => Cashier::ACTIVE]);
    }

    /**
     * @return CashierQuery
     */
    public function virtual() {
        return $this->andWhere(['virtual' => Cashier::VIRTUAL]);
    }

    /**
     * @return CashierQuery
     */
    public function notVirtual() {
        return $this->andWhere(['virtual' => Cashier::NOT_VIRTUAL]);
    }
}