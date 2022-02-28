<?php

use yii\db\Migration;

/**
 * Class m200826_091921_add_actual_price_type_column
 */
class m200826_091921_add_actual_price_type_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tariff', 'actual_price_type', $this->smallInteger(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200826_091921_add_actual_price_type_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200826_091921_add_actual_price_type_column cannot be reverted.\n";

        return false;
    }
    */
}
