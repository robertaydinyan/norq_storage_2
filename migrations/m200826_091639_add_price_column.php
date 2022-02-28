<?php

use yii\db\Migration;

/**
 * Class m200826_091639_add_price_column
 */
class m200826_091639_add_price_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('internet', 'price', $this->decimal(10,2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200826_091639_add_price_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200826_091639_add_price_column cannot be reverted.\n";

        return false;
    }
    */
}
