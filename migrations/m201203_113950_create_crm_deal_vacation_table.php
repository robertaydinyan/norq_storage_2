<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_deal_vacation}}`.
 */
class m201203_113950_create_crm_deal_vacation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_deal_vacation}}', [
            'id' => $this->primaryKey(),
            'deal_id' => $this->integer(),
            'data_start' => $this->dateTime(),
            'data_end' => $this->dateTime(),
            'status' => $this->integer()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%crm_deal_vacation}}');
    }
}
