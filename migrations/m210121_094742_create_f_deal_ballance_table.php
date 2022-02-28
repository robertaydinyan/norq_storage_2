<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_deal_ballance}}`.
 */
class m210121_094742_create_f_deal_ballance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_deal_ballance}}', [
            'deal_number' => $this->string(),
            'balance' => $this->money(10, 2),
            'date' => $this->date(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_deal_ballance}}');
    }
}
