<?php

use yii\db\Migration;

/**
 * Class m200916_103458_add_deal_ip_table
 */
class m200916_103458_add_deal_ip_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%deal_ip}}', [
            'id' => $this->primaryKey(),
            'deal_id' => $this->integer(),
            'ip_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%deal_ip}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200916_103458_add_deal_ip_table cannot be reverted.\n";

        return false;
    }
    */
}
