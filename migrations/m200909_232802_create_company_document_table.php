<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%company_document}}`.
 */
class m200909_232802_create_company_document_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%company_document}}', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(),
            'image' => $this->string(),
            'type' => $this->integer()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%company_document}}');
    }
}
