<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%deal_payment_log}}`.
 */
class m200916_095812_create_deal_payment_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%deal_payment_log}}', [
            'id' => $this->primaryKey(),
            'deal_id' => $this->integer(),
            'price' => $this->decimal(10, 2),
            'create_at' => $this->timestamp(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%deal_payment_log}}');
    }
}
