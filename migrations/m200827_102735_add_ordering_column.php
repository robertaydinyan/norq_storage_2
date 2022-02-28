<?php

use yii\db\Migration;

/**
 * Class m200827_102735_add_ordering_column
 */
class m200827_102735_add_ordering_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_status', 'ordering', $this->integer()->defaultValue(-1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200827_102735_add_ordering_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200827_102735_add_ordering_column cannot be reverted.\n";

        return false;
    }
    */
}
