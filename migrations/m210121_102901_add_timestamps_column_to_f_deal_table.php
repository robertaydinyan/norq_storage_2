<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%f_deal}}`.
 */
class m210121_102901_add_timestamps_column_to_f_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal', 'create_at', $this->dateTime());
        $this->addColumn('f_deal', 'update_at', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
