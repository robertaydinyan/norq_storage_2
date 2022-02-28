<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_deal_ip}}`.
 */
class m201224_141752_create_f_deal_ip_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_deal_ip}}', [
            'id' => $this->primaryKey(),
            'deal_id' =>$this->integer()->notNull(),
            'address' => $this->string(),
            'status' => $this->smallInteger(1)->defaultValue(0)->comment('ete 1 e anvchar e')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_deal_ip}}');
    }
}
