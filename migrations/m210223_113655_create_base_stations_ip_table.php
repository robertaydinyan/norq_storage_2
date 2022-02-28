<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%base_stations_ip}}`.
 */
class m210223_113655_create_base_stations_ip_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%base_stations_ip}}', [
            'deal_number' => $this->string(),
            'ip_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%base_stations_ip}}');
    }
}
