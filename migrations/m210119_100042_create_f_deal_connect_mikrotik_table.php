<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_deal_connect_mikrotik}}`.
 */
class m210119_100042_create_f_deal_connect_mikrotik_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_deal_connect_mikrotik}}', [
            'deal_id' => $this->integer()->notNull(),
            'mikrotik_id' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_deal_connect_mikrotik}}');
    }
}
