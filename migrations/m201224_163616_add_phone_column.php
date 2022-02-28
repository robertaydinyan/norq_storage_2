<?php

use yii\db\Migration;

/**
 * Class m201224_163616_add_phone_column
 */
class m201224_163616_add_phone_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_contact', 'phone', $this->string());
        $this->addColumn('crm_contact', 'email', $this->string());
        $this->addColumn('crm_company', 'phone', $this->string());
        $this->addColumn('crm_company', 'email', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201224_163616_add_phone_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201224_163616_add_phone_column cannot be reverted.\n";

        return false;
    }
    */
}
