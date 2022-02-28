<?php

use yii\db\Migration;

/**
 * Class m200903_171909_create_product_id_column_to_service_tariff
 */
class m200903_171909_create_product_id_column_to_service_tariff extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('service_tariff', 'product_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200903_171909_create_product_id_column_to_service_tariff cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200903_171909_create_product_id_column_to_service_tariff cannot be reverted.\n";

        return false;
    }
    */
}
