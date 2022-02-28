<?php

use yii\db\Migration;

/**
 * Class m201225_124404_add_start_deal_column
 */
class m201225_124404_add_start_deal_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal', 'start_deal', $this->smallInteger(1)->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201225_124404_add_start_deal_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201225_124404_add_start_deal_column cannot be reverted.\n";

        return false;
    }
    */
}
