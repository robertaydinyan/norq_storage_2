<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%company_type}}`.
 */
class m200902_151036_create_company_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%company_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%company_type}}');
    }
}
