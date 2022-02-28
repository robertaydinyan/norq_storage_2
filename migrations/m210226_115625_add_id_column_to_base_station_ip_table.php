<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%base_station_ip}}`.
 */
class m210226_115625_add_id_column_to_base_station_ip_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('base_stations_ip', 'id', $this->primaryKey()->first());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
