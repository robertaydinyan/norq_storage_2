<?php

use yii\db\Migration;

/**
 * Class m200903_111735_add_tariff_id_service_id_columns_deal
 */
class m200903_111735_add_tariff_id_service_id_columns_deal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_deal', 'service_id', $this->integer());
        $this->addColumn('crm_deal', 'tariff_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200903_111735_add_tariff_id_service_id_columns_deal cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200903_111735_add_tariff_id_service_id_columns_deal cannot be reverted.\n";

        return false;
    }
    */
}
