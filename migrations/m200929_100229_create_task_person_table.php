<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_person}}`.
 */
class m200929_100229_create_task_person_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task_person}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'person_id' => $this->integer(),
            'status' => $this->integer(),
        ]);
        $this->createIndex('unique_all_columns', 'task_person','task_id, person_id, status',1
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task_person}}');
    }
}
