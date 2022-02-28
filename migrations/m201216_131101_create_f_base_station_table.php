<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_base_station}}`.
 */
class m201216_131101_create_f_base_station_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_base_station}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'ip' => $this->string(),
            'zona_id' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_base_station}}');
    }
}
