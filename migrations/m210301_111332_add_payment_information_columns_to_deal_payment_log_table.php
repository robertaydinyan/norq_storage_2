<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%deal_payment_log}}`.
 */
class m210301_111332_add_payment_information_columns_to_deal_payment_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('deal_payment_log', 'receipt', $this->string()->null());
        $this->addColumn('deal_payment_log', 'pay_date', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
