<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%custom_list}}`.
 */
class m200821_135023_create_custom_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_custom_list}}', [
            'id' => $this->primaryKey(),
            'custom_field_id' => $this->integer(),
            'value' => $this->string()
        ]);

        $this->createTable('{{%crm_custom_list_lang}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(6),
            'value' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%custom_list}}');
    }
}
