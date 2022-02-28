<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%s_warehouse}}`.
 */
class m210616_111146_create_s_warehouse_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%s_warehouse}}', [
            'id' => $this->primaryKey(),
            'type' =>$this->string()->notNull(),
            'country' =>$this->string(),
            'region' =>$this->string(),
            'city' =>$this->string(),
            'address' =>$this->string(),
            'responsible_person' =>$this->string(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),

            'user_id' => $this->integer(),
            'crm_company_id' => $this->integer(),
            'crm_contact_id' => $this->integer()

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%s_warehouse}}');
    }
}
