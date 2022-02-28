<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%f_deal_disabled_day}}`.
 */
class m210305_111925_add_message_column_to_f_deal_disabled_day_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%f_deal_disabled_day}}', 'message', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
