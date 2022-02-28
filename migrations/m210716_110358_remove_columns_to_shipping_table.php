<?php

use yii\db\Migration;

/**
 * Class m210716_110358_remove_columns_to_shipping_table
 */
class m210716_110358_remove_columns_to_shipping_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('s_shipping', 'shipping_request_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210716_110358_remove_columns_to_shipping_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210716_110358_remove_columns_to_shipping_table cannot be reverted.\n";

        return false;
    }
    */
}
