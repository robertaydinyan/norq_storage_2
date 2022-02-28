<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_task}}`.
 */
class m210420_120138_create_f_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_task}}', [
            'id' => $this->primaryKey(),
            'created_by' => $this->integer()->comment('Current user ID'),
            'task_option_id' => $this->integer(),
            'priority' => $this->integer(),
            'open_date' => $this->dateTime(),
            'close_date' => $this->dateTime(),
            'description' => $this->text(),
            'create_at' => $this->dateTime(),
            'update_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_task}}');
    }
}
