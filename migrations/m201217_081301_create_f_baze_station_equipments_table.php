<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_baze_station_equipments}}`.
 */
class m201217_081301_create_f_baze_station_equipments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_baze_station_equipments}}', [
            'id' => $this->primaryKey(),
            'base_id' => $this->integer(),
            'equipment_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_baze_station_equipments}}');
    }
}
