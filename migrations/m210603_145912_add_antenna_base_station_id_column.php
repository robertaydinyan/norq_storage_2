<?php

use yii\db\Migration;

/**
 * Class m210603_145912_add_antenna_base_station_id_column
 */
class m210603_145912_add_antenna_base_station_id_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_antenna_ip', 'base_station_id', $this->integer()->after('id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210603_145912_add_antenna_base_station_id_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210603_145912_add_antenna_base_station_id_column cannot be reverted.\n";

        return false;
    }
    */
}
