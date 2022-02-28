<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%f_deal_ip}}`.
 */
class m210308_130224_add_deal_number_column_to_f_deal_ip_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('f_deal_ip', 'deal_id');
        $this->addColumn('f_deal_ip', 'deal_number', $this->string()->after('id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
