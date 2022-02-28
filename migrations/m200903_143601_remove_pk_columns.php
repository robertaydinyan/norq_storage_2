<?php

use yii\db\Migration;

/**
 * Class m200903_143601_remove_pk_columns
 */
class m200903_143601_remove_pk_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropPrimaryKey('services-service_country_pk', 'service_country');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200903_143601_remove_pk_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200903_143601_remove_pk_columns cannot be reverted.\n";

        return false;
    }
    */
}
