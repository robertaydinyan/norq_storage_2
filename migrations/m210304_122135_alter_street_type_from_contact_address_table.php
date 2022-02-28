<?php

use yii\db\Migration;

/**
 * Class m210304_122135_alter_street_type_from_contact_address_table
 */
class m210304_122135_alter_street_type_from_contact_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('contact_adress', 'street', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210304_122135_alter_street_type_from_contact_address_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210304_122135_alter_street_type_from_contact_address_table cannot be reverted.\n";

        return false;
    }
    */
}
