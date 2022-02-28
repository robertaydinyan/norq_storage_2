<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%deal_payment_log}}`.
 */
class m210331_085407_add_payer_column_to_deal_payment_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('deal_payment_log', 'payer', $this->integer()->null()->comment('Վճարում ընդունող օպերատոր'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
