<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%f_cashier}}`.
 */
class m210326_082520_add_virtual_column_to_f_cashier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_cashier', 'virtual', $this->smallInteger()->defaultValue(0)->comment('0 => Not virtual, 1 => Virtual'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
