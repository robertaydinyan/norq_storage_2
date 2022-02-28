<?php

use yii\db\Migration;

/**
 * Class m200907_122115_add_column_id_crm_contact_email
 */
class m200907_122115_add_column_id_crm_contact_email extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('contact_email', 'id', $this->primaryKey());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200907_122115_add_column_id_crm_contact_email cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200907_122115_add_column_id_crm_contact_email cannot be reverted.\n";

        return false;
    }
    */
}
