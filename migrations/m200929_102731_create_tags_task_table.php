<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tags_task}}`.
 */
class m200929_102731_create_tags_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tags_task}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);
        $this->createIndex('unique_all_columns', 'tags_task','task_id, tag_id',1
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tags_task}}');
    }
}
