<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ip_addresses}}`.
 */
class m200825_131121_create_ip_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ip_addresses}}', [
            'id' => $this->primaryKey(),
            'address' => $this->string(),
            'status' => $this->integer()->defaultValue(0),
            'price' => $this->decimal(10, 2),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ip_addresses}}');
    }
}
