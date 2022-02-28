<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_cash_register_receipt}}`.
 */
class m210423_114257_create_crm_cash_register_receipt_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_cash_register_receipt}}', [
            'id' => $this->primaryKey(),
            'payment_log_id' => $this->integer(),
            'cashier_id' => $this->integer(),
            'created_by' => $this->integer(),
            'accepted_at' => $this->dateTime(),
            'create_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%crm_cash_register_receipt}}');
    }
}
