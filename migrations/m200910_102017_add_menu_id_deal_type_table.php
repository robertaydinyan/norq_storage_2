<?php

use yii\db\Migration;

/**
 * Class m200910_102017_add_menu_id_deal_type_table
 */
class m200910_102017_add_menu_id_deal_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('deal_type', 'menu_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200910_102017_add_menu_id_deal_type_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200910_102017_add_menu_id_deal_type_table cannot be reverted.\n";

        return false;
    }
    */
}
