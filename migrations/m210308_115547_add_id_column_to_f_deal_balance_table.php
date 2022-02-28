<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%f_deal_balance}}`.
 */
class m210308_115547_add_id_column_to_f_deal_balance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal_ballance', 'id', $this->primaryKey()->first());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
