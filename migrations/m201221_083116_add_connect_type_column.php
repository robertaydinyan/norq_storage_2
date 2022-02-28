<?php

use yii\db\Migration;

/**
 * Class m201221_083116_add_connect_type_column
 */
class m201221_083116_add_connect_type_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal', 'connect_type', $this->integer());
        $this->addColumn('f_deal', 'binding_speed', $this->integer());
        $this->addColumn('f_deal', 'is_wifi', $this->smallInteger()->defaultValue(0));
        $this->addColumn('f_deal', 'wifi_code', $this->string());
        $this->addColumn('f_deal', 'electricity', $this->decimal(10, 2));
        $this->addColumn('f_deal', 'free', $this->smallInteger()->defaultValue(0));
        $this->addColumn('f_deal', 'discount', $this->decimal(10, 2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201221_083116_add_connect_type_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201221_083116_add_connect_type_column cannot be reverted.\n";

        return false;
    }
    */
}
