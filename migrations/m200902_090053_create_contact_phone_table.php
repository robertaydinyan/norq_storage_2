<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact_phone}}`.
 */
class m200902_090053_create_contact_phone_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_contact_phone}}', [
            'contact_id' => $this->integer(),
            'company_id' => $this->integer(),
            'phone' => $this->string()->unique(),
            'phone_type_id' => $this->integer(),

        ]);

        $this->createTable('{{%crm_phone_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'for_what' => $this->smallInteger(1)->comment('0=>phone; mail => 1'),


        ]);

        $this->createTable('{{%crm_phone_type_lang}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(6),
            'name' => $this->string()
        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contact_phone}}');
    }
}
