<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%deal_payment_log}}`.
 */
class m210329_102906_add_hdm_column_to_deal_payment_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('deal_payment_log', 'hdm', $this->smallInteger()->defaultValue(0)->comment('0 => HDM che, 1 => HDM'));
        $this->addColumn('deal_payment_log', 'comment', $this->text()->comment('Cashier change history'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
