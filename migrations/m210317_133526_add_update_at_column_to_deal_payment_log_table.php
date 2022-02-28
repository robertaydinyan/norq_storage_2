<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%deal_payment_log}}`.
 */
class m210317_133526_add_update_at_column_to_deal_payment_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('deal_payment_log', 'update_at', $this->dateTime()->after('create_at')->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
