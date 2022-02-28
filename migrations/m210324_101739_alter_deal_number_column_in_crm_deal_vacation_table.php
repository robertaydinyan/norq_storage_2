<?php

use yii\db\Migration;

/**
 * Class m210324_101739_alter_deal_number_column_in_crm_deal_vacation_table
 */
class m210324_101739_alter_deal_number_column_in_crm_deal_vacation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('crm_deal_vacation', 'deal_number', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210324_101739_alter_deal_number_column_in_crm_deal_vacation_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210324_101739_alter_deal_number_column_in_crm_deal_vacation_table cannot be reverted.\n";

        return false;
    }
    */
}
