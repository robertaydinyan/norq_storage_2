<?php

use yii\db\Migration;

/**
 * Class m210201_080253_rename_deal_id_column
 */
class m210201_080253_rename_deal_id_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('f_deal_connect_mikrotik', 'deal_id', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210201_080253_rename_deal_id_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210201_080253_rename_deal_id_column cannot be reverted.\n";

        return false;
    }
    */
}
