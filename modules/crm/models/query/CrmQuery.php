<?php


namespace app\modules\crm\models\query;

class CrmQuery
{

    /**
     * @param $id
     * @param false $isCompany
     * @return array|\yii\db\DataReader|null
     * @throws \yii\db\Exception
     */
    public static function getProducts($id, $isCompany = false)
    {
        if (!is_null($id)) {

            $where = null;

            if ($isCompany === true) {
                $where = "`crm_deal`.`company_id` = {$id}";
            } else {
                $where = "`crm_deal`.`contact_id` = {$id}";
            }

            $sql = "SELECT `crm_product`.*, `deal_conect`.`product_price`, `crm_deal`.`amount`, `currency`.`name` AS `currency_code`, `crm_deal`.`create_at` AS `deal_created_at` FROM `crm_deal`
                    LEFT JOIN `deal_conect` ON `deal_conect`.`deal_id` = `crm_deal`.`id`
                    LEFT JOIN `crm_product` ON `crm_product`.`id` = `deal_conect`.`product_id`
                    LEFT JOIN `currency` ON `currency`.`id` = `crm_product`.`currency_id`
                    WHERE {$where} AND `crm_product`.`eq_or_sup` = 1";

            return \Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_OBJ);
        } else {
            return null;
        }

    }

}