<?php

use yii\db\Migration;

/**
 * Class m200902_151756_add_column_amount_column
 */
class m200902_151756_add_column_amount_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_lead', 'amount', $this->decimal(10, 2));
        $this->addColumn('crm_lead', 'currency_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200902_151756_add_column_amount_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200902_151756_add_column_amount_column cannot be reverted.\n";

        return false;
    }
    */
}
