<?php

use yii\db\Migration;

/**
 * Class m201229_133309_add_status_column_f_deal_table
 */
class m201229_133309_add_status_column_f_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal', 'status', $this->smallInteger(1)->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201229_133309_add_status_column_f_deal_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201229_133309_add_status_column_f_deal_table cannot be reverted.\n";

        return false;
    }
    */
}
