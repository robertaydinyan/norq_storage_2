<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_contact_passport}}`.
 */
class m200909_115903_create_crm_contact_passport_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_contact_passport}}', [
            'id' => $this->primaryKey(),
            'contact_id' => $this->integer(),
            'image' => $this->string(),
            'type' => $this->integer()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%crm_contact_passport}}');
    }
}
