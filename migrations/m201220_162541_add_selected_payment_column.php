<?php

use yii\db\Migration;

/**
 * Class m201220_162541_add_selected_payment_column
 */
class m201220_162541_add_selected_payment_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal', 'selected_payment_id', $this->integer());
        $this->addColumn('f_deal', 'base_station_id', $this->integer());
        $this->addColumn('f_deal', 'local_ip', $this->integer());
        $this->addColumn('f_deal', 'contract_start', $this->dateTime());
        $this->addColumn('f_deal', 'contract_end', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201220_162541_add_selected_payment_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201220_162541_add_selected_payment_column cannot be reverted.\n";

        return false;
    }
    */
}
