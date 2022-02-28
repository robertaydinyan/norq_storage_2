<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_task_priority}}`.
 */
class m210420_131033_create_f_task_priority_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_task_priority}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'color' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_task_priority}}');
    }
}
