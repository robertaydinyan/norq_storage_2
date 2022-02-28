<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%deal_payment_log_history}}`.
 */
class m210409_132051_create_deal_payment_log_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%deal_payment_log_history}}', [
            'deal_payment_log_id' => $this->integer(),
            'previous_cashier_id' => $this->integer(),
            'current_cashier_id' => $this->integer(),
            'create_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%deal_payment_log_history}}');
    }
}
