<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%f_cashier}}`.
 */
class m210317_084957_add_blacklist_column_to_f_cashier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%f_cashier}}', 'blacklist', $this->smallInteger()->defaultValue(0)->comment('0 => Black | 1 => White'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
