<?php

use yii\db\Migration;

/**
 * Class m200908_130150_add_column_address_id_deal
 */
class m200908_130150_add_column_address_id_deal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_deal', 'address_id', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200908_130150_add_column_address_id_deal cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200908_130150_add_column_address_id_deal cannot be reverted.\n";

        return false;
    }
    */
}
