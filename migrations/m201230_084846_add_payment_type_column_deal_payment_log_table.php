<?php

use yii\db\Migration;

/**
 * Class m201230_084846_add_payment_type_column_deal_payment_log_table
 */
class m201230_084846_add_payment_type_column_deal_payment_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('deal_payment_log', 'payment_type', $this->smallInteger(1)->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201230_084846_add_payment_type_column_deal_payment_log_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201230_084846_add_payment_type_column_deal_payment_log_table cannot be reverted.\n";

        return false;
    }
    */
}
