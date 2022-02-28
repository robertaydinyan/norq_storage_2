<?php

use yii\db\Migration;

/**
 * Class m201218_101125_add_column_ip_end_f_base_station_table
 */
class m201218_101125_add_column_ip_end_f_base_station_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_base_station', 'ip_end', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201218_101125_add_column_ip_end_f_base_station_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201218_101125_add_column_ip_end_f_base_station_table cannot be reverted.\n";

        return false;
    }
    */
}
