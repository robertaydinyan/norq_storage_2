<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_task_option}}`.
 */
class m210420_120006_create_f_task_option_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_task_option}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_task_option}}');
    }
}
