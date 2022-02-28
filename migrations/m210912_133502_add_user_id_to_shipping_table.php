<?php

use yii\db\Migration;

/**
 * Class m210912_133502_add_user_id_to_shipping_table
 */
class m210912_133502_add_user_id_to_shipping_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%s_shipping}}', 'user_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210912_133502_add_user_id_to_shipping_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210912_133502_add_user_id_to_shipping_table cannot be reverted.\n";

        return false;
    }
    */
}
