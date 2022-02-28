<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%company_scope_lang}}`.
 */
class m200902_151521_create_company_scope_lang_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%company_scope_lang}}', [
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
        $this->dropTable('{{%company_scope_lang}}');
    }
}
