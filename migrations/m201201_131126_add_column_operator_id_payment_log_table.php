<?php

use yii\db\Migration;

/**
 * Class m201201_131126_add_column_operator_id_payment_log_table
 */
class m201201_131126_add_column_operator_id_payment_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('deal_payment_log', 'operator_id', $this->integer());
        $this->addColumn('deal_payment_log', 'status', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201201_131126_add_column_operator_id_payment_log_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201201_131126_add_column_operator_id_payment_log_table cannot be reverted.\n";

        return false;
    }
    */
}
