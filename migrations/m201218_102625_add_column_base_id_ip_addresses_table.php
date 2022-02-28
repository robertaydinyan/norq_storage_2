<?php

use yii\db\Migration;

/**
 * Class m201218_102625_add_column_base_id_ip_addresses_table
 */
class m201218_102625_add_column_base_id_ip_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ip_addresses', 'base_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201218_102625_add_column_base_id_ip_addresses_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201218_102625_add_column_base_id_ip_addresses_table cannot be reverted.\n";

        return false;
    }
    */
}
