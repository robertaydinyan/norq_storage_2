<?php

use yii\db\Migration;

/**
 * Class m210118_150049_add_connection_date_to_f_deal_table
 */
class m210118_150049_add_connection_date_to_f_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal', 'connection_day', $this->date()->null()->after('contract_end'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210118_150049_add_connection_date_to_f_deal_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210118_150049_add_connection_date_to_f_deal_table cannot be reverted.\n";

        return false;
    }
    */
}
