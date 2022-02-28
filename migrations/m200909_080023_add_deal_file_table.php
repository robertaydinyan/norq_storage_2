<?php

use yii\db\Migration;

/**
 * Class m200909_080023_add_deal_file_table
 */
class m200909_080023_add_deal_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_deal_file}}', [
            'id' => $this->primaryKey(),
            'deal_id' => $this->integer(),
            'file' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200909_080023_add_deal_file_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200909_080023_add_deal_file_table cannot be reverted.\n";

        return false;
    }
    */
}
