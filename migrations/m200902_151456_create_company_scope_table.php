<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%company_scope}}`.
 */
class m200902_151456_create_company_scope_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%company_scope}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%company_scope}}');
    }
}
