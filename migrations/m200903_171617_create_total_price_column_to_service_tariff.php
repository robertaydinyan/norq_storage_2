<?php

use yii\db\Migration;

/**
 * Class m200903_171617_create_total_price_column_to_service_tariff
 */
class m200903_171617_create_total_price_column_to_service_tariff extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('service_tariff', 'total_price', $this->decimal(10, 2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200903_171617_create_total_price_column_to_service_tariff cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200903_171617_create_total_price_column_to_service_tariff cannot be reverted.\n";

        return false;
    }
    */
}
