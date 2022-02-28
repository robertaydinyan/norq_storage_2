<?php

use yii\db\Migration;

/**
 * Class m210128_120807_add_price_column
 */
class m210128_120807_add_price_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal_disabled_day', 'price', $this->decimal(10, 2)->defaultValue(99));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210128_120807_add_price_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210128_120807_add_price_column cannot be reverted.\n";

        return false;
    }
    */
}
