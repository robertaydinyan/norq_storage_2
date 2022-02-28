<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_contact}}`.
 */
class m200826_125237_create_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_contact}}', [
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
        $this->dropTable('{{%crm_contact}}');
    }
}
