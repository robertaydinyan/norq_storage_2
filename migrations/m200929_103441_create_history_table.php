<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%history}}`.
 */
class m200929_103441_create_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%history}}', [
            'id' => $this->primaryKey(),
            'old_state' => $this->string(),
            'new_state' => $this->string(),
            'person_id' => $this->integer(),
            'created_add' => $this->dateTime(),
            'task_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%history}}');
    }
}
