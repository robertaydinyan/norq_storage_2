<?php

use yii\db\Migration;

/**
 * Class m201209_114002_add_column_deal_end_status_crm_deal_table
 */
class m201209_114002_add_column_deal_end_status_crm_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_deal', 'deal_end_status', $this->integer()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201209_114002_add_column_deal_end_status_crm_deal_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201209_114002_add_column_deal_end_status_crm_deal_table cannot be reverted.\n";

        return false;
    }
    */
}
