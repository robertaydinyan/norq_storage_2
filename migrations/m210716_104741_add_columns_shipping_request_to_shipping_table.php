<?php

use yii\db\Migration;

/**
 * Class m210716_104741_add_columns_shipping_request_to_shipping_table
 */
class m210716_104741_add_columns_shipping_request_to_shipping_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%s_shipping}}', 'shipping_request_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210716_104741_add_columns_shipping_request_to_shipping_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210716_104741_add_columns_shipping_request_to_shipping_table cannot be reverted.\n";

        return false;
    }
    */
}
