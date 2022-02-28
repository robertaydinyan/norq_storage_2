<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_deal}}`.
 */
class m201218_115702_create_f_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_deal}}', [
            'id' => $this->primaryKey(),
            'deal_number' => $this->string(),
            'contact_id' => $this->integer(),
            'is_provider' => $this->integer(), // 1 - true 0 - false
            'user_type' => $this->integer(),   // 1 - Phys 0 - Legal
            'connect_id' => $this->integer(),
            'discount_id' => $this->integer(),
            'share_id' => $this->integer(),
            'amount' => $this->decimal(10, 2),   // Total Price
            'penalty' => $this->decimal(10, 2),   // Tuganq / Penalty
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_deal}}');
    }
}
