<?php

use yii\db\Migration;

/**
 * Class m210326_064714_alter_create_at_column_to_deal_payment_log_table
 */
class m210326_064714_alter_create_at_column_to_deal_payment_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('deal_payment_log', 'create_at', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210326_064714_alter_create_at_column_to_deal_payment_log_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210326_064714_alter_create_at_column_to_deal_payment_log_table cannot be reverted.\n";

        return false;
    }
    */
}
