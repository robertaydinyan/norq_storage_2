<?php

use yii\db\Migration;

/**
 * Class m201224_155043_add_service_type_to_f_deal_table
 */
class m201224_155043_add_service_type_to_f_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%f_deal}}', 'service_type', $this->smallInteger(3)->after('is_provider'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201224_155043_add_service_type_to_f_deal_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201224_155043_add_service_type_to_f_deal_table cannot be reverted.\n";

        return false;
    }
    */
}
