<?php

use yii\db\Migration;

/**
 * Class m210715_083620_remove_columns_to_warehouse_table
 */
class m210715_083620_remove_columns_to_warehouse_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('s_warehouse', 'country');
        $this->dropColumn('s_warehouse', 'region');
        $this->dropColumn('s_warehouse', 'city');
        $this->dropColumn('s_warehouse', 'address');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210715_083620_remove_columns_to_warehouse_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210715_083620_remove_columns_to_warehouse_table cannot be reverted.\n";

        return false;
    }
    */
}
