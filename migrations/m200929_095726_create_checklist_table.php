<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%checklist}}`.
 */
class m200929_095726_create_checklist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%checklist}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'sort' => $this->integer(),
            'task_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%checklist}}');
    }
}
