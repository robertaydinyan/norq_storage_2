<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%company}}`.
 */
class m200826_103930_create_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_company}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'create_at' => $this->dateTime(),
            'update_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%crm_company}}');
    }
}
