<?php

use yii\db\Migration;

/**
 * Class m210128_102434_add_microtik_queue_id_column
 */
class m210128_102434_add_microtik_queue_id_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal_connect_mikrotik', 'micro_queue_id', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210128_102434_add_microtik_queue_id_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210128_102434_add_microtik_queue_id_column cannot be reverted.\n";

        return false;
    }
    */
}
