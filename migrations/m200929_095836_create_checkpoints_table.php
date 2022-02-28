<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%checkpoints}}`.
 */
class m200929_095836_create_checkpoints_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%checkpoints}}', [
            'id' => $this->primaryKey(),
            'context' => $this->string(),
            'status' => $this->integer(),
            'important' => $this->integer(),
            'sort' => $this->integer(),
            'checklist_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%checkpoints}}');
    }
}
