<?php

use yii\db\Migration;

/**
 * Class m210223_111131_add_start_day_to_f_deal_table
 */
class m210223_111131_add_start_day_to_f_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal', 'start_day', $this->date()->after('contract_end'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210223_111131_add_start_day_to_f_deal_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210223_111131_add_start_day_to_f_deal_table cannot be reverted.\n";

        return false;
    }
    */
}
