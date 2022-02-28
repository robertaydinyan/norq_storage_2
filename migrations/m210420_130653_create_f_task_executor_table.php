<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_task_executor}}`.
 */
class m210420_130653_create_f_task_executor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_task_executor}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'executor_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_task_executor}}');
    }
}
