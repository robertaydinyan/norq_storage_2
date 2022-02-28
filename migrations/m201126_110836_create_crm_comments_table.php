<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_comments}}`.
 */
class m201126_110836_create_crm_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_comments}}', [
            'id' => $this->primaryKey(),
            'contact_id' => $this->integer()->null(),
            'company_id' => $this->integer()->null(),
            'crm_type' => $this->integer()->defaultValue(1),
            'comment' => $this->text()->notNull(),
            'create_at' => $this->dateTime(),
            'update_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%crm_comments}}');
    }
}
