<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_deal_antenna_ip}}`.
 */
class m210407_131653_create_f_deal_antenna_ip_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_deal_antenna_ip}}', [
            'id' => $this->primaryKey(),
            'deal_number' => $this->string(),
            'antenna_ip_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_deal_antenna_ip}}');
    }
}
