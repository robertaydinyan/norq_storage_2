<?php

use yii\db\Migration;

/**
 * Class m200915_122246_add_column_start_deal
 */
class m200915_122246_add_column_start_deal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_deal', 'start_deal', $this->integer()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200915_122246_add_column_start_deal cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200915_122246_add_column_start_deal cannot be reverted.\n";

        return false;
    }
    */
}
