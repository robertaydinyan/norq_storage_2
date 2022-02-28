<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%f_deal}}`.
 */
class m210429_132224_add_daily_column_to_f_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal', 'is_daily', $this->boolean()->defaultValue(0));
        $this->addColumn('f_deal', 'month', $this->integer()->comment('Contract months for daily'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
