<?php

use yii\db\Migration;

/**
 * Class m201202_080921_add_column_last_name_user_table
 */
class m201202_080921_add_column_last_name_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'last_name', $this->string()->defaultValue(''));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201202_080921_add_column_last_name_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201202_080921_add_column_last_name_user_table cannot be reverted.\n";

        return false;
    }
    */
}
