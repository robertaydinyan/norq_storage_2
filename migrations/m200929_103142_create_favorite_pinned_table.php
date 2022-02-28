<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%favorite_pinned}}`.
 */
class m200929_103142_create_favorite_pinned_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%favorite_pinned}}', [
            'id' => $this->primaryKey(),
            'person_id' => $this->integer(),
            'task_id' => $this->integer(),
            'status' => $this->integer(),
            'type' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%favorite_pinned}}');
    }
}
