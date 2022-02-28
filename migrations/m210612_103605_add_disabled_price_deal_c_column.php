<?php

use yii\db\Migration;

/**
 * Class m210612_103605_add_disabled_price_deal_c_column
 */
class m210612_103605_add_disabled_price_deal_c_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal', 'disabled_price_deal_c', $this->integer(11)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210612_103605_add_disabled_price_deal_c_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210612_103605_add_disabled_price_deal_c_column cannot be reverted.\n";

        return false;
    }
    */
}
