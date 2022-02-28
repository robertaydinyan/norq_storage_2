<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%deal}}`.
 */
class m210208_115638_add_speed_dates_column_to_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal', 'speed_date_start', $this->date()->after('binding_speed')->null());
        $this->addColumn('f_deal', 'speed_date_end', $this->date()->after('speed_date_start')->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
