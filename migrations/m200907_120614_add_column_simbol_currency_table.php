<?php

use yii\db\Migration;

/**
 * Class m200907_120614_add_column_simbol_currency_table
 */
class m200907_120614_add_column_simbol_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('currency', 'symbol', $this->string(60));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200907_120614_add_column_simbol_currency_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200907_120614_add_column_simbol_currency_table cannot be reverted.\n";

        return false;
    }
    */
}
