<?php

use yii\db\Migration;

/**
 * Class m200907_125439_add_columns_is_mailing_is_notification_for_contact_email
 */
class m200907_125439_add_columns_is_mailing_is_notification_for_contact_email extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('contact_email', 'is_mailing', $this->integer()->defaultValue(0));
        $this->addColumn('contact_email', 'is_notification', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200907_125439_add_columns_is_mailing_is_notification_for_contact_email cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200907_125439_add_columns_is_mailing_is_notification_for_contact_email cannot be reverted.\n";

        return false;
    }
    */
}
