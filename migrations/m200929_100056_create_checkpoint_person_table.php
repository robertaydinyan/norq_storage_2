<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%checkpoint_person}}`.
 */
class m200929_100056_create_checkpoint_person_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%checkpoint_person}}', [
            'id' => $this->primaryKey(),
            'point_id' => $this->integer(),
            'person_id' => $this->integer(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%checkpoint_person}}');
    }
}
