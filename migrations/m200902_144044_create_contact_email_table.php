<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact_email}}`.
 */
class m200902_144044_create_contact_email_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact_email}}', [
            'contact_id' => $this->integer(),
            'company_id' => $this->integer(),
            'name' => $this->string()->unique(),
            'email_type_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contact_email}}');
    }
}
