<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%section}}`.
 */
class m200821_130408_create_section_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_section}}', [
            'id' => $this->primaryKey(),
            'menu_id' => $this->integer(),
            'name' => $this->string()

        ]);

        $this->createTable('{{%crm_section_lang}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(6),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%crm_section}}');
    }
}
