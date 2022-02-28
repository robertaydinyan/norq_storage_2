<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_antenna_ip}}`.
 */
class m210407_121947_create_f_antenna_ip_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_antenna_ip}}', [
            'id' => $this->primaryKey(),
            'ip_address' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_antenna_ip}}');
    }
}
