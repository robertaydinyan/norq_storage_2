<?php

use yii\db\Migration;

/**
 * Class m200907_125452_add_columns_is_mailing_is_notification_for_contact_phone
 */
class m200907_125452_add_columns_is_mailing_is_notification_for_contact_phone extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_contact_phone', 'is_mailing', $this->integer()->defaultValue(0));
        $this->addColumn('crm_contact_phone', 'is_notification', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200907_125452_add_columns_is_mailing_is_notification_for_contact_phone cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200907_125452_add_columns_is_mailing_is_notification_for_contact_phone cannot be reverted.\n";

        return false;
    }
    */
}
