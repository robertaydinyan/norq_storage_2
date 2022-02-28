<?php

use yii\db\Migration;

/**
 * Class m200916_065648_remove_address_id_column_crm_deal_table
 */
class m200916_065648_remove_address_id_column_crm_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('crm_deal', 'address_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200916_065648_remove_address_id_column_crm_deal_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200916_065648_remove_address_id_column_crm_deal_table cannot be reverted.\n";

        return false;
    }
    */
}
