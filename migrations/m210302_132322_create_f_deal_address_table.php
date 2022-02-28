<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_deal_address}}`.
 */
class m210302_132322_create_f_deal_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_deal_address}}', [
            'id' => $this->primaryKey(),
            'deal_number' => $this->string(),
            'contact_address_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_deal_address}}');
    }
}
