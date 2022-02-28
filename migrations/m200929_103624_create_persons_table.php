<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%persons}}`.
 */
class m200929_103624_create_persons_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%persons}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'surname' => $this->string(),
            'mid_name' => $this->string(),
            'sender' => $this->integer(),
            'avatar' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%persons}}');
    }
}
