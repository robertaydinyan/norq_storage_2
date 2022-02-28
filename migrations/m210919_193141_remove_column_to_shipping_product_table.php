<?php

use yii\db\Migration;

/**
 * Class m210919_193141_remove_column_to_shipping_product_table
 */
class m210919_193141_remove_column_to_shipping_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('s_shipping_product', 'nomenclature_product_id');
        $this->dropColumn('s_shipping_product', 'mac_address');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210919_193141_remove_column_to_shipping_product_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210919_193141_remove_column_to_shipping_product_table cannot be reverted.\n";

        return false;
    }
    */
}
