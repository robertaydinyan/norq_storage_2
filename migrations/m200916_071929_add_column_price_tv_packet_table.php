<?php

use yii\db\Migration;

/**
 * Class m200916_071929_add_column_price_tv_packet_table
 */
class m200916_071929_add_column_price_tv_packet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tv_packet', 'price', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200916_071929_add_column_price_tv_packet_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200916_071929_add_column_price_tv_packet_table cannot be reverted.\n";

        return false;
    }
    */
}
