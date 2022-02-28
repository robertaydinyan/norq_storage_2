<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%f_deal}}`.
 */
class m210512_080006_add_daily_columns_to_f_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal', 'daily_finish_month', $this->date()->after('connection_day')->comment('Contract finish month for daily'));
        $this->addColumn('f_deal', 'daily_month_end', $this->date()->after('daily_finish_month')->comment('Contract one month ending for daily'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
