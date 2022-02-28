<?php

use yii\db\Migration;

/**
 * Class m210720_142050_remove_product_id_column_to_shipping_table
 */
class m210720_142050_remove_product_id_column_to_shipping_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('s_shipping_product', 'product_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210720_142050_remove_product_id_column_to_shipping_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210720_142050_remove_product_id_column_to_shipping_table cannot be reverted.\n";

        return false;
    }
    */
}
