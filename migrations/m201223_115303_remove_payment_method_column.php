<?php

use yii\db\Migration;

/**
 * Class m201223_115303_remove_payment_method_column
 */
class m201223_115303_remove_payment_method_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('f_deal', 'selected_payment_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201223_115303_remove_payment_method_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201223_115303_remove_payment_method_column cannot be reverted.\n";

        return false;
    }
    */
}
