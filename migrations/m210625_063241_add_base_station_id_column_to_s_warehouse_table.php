<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%s_warehouse}}`.
 */
class m210625_063241_add_base_station_id_column_to_s_warehouse_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%s_warehouse}}', 'base_station_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%s_warehouse}}', 'base_station_id');
    }
}
