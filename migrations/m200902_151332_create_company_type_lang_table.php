<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%company_type_lang}}`.
 */
class m200902_151332_create_company_type_lang_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%company_type_lang}}', [
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
        $this->dropTable('{{%company_type_lang}}');
    }
}
