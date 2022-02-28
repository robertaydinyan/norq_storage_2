<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_menu}}`.
 */
class m200821_124311_create_crm_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_menu}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%crm_menu}}');
    }
}
