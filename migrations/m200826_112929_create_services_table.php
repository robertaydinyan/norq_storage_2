<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%services}}`.
 */
class m200826_112929_create_services_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%services}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            //'tariff_id' => $this->integer(),
            'services_client_type' => $this->smallInteger(1),
            'payment_type' => $this->smallInteger(1),
            'payment_period' => $this->smallInteger(1),
            'random' => $this->integer(),
            'is_all_country' => $this->smallInteger(1),
        ]);

        $this->createTable('{{service_tariff}}', [
            'service_id' => $this->integer(),
            'tariff_id' => $this->integer(),
            'actual_price_type' => $this->smallInteger(1),
            'actual_price' => $this->decimal(10, 2),
        ]);

        $this->addPrimaryKey('service_tariff_pk', '{{%service_tariff}}', ['service_id', 'tariff_id']);

        $this->createTable('{{service_tariff_location}}', [
            'service_id' => $this->integer(),
            'tariff_id' => $this->integer(),
            'country_id' => $this->integer(),
            'region_id' => $this->integer(),
            'city_id' => $this->integer(),
        ]);

        $this->addPrimaryKey('service_tariff_location_pk', '{{%service_tariff_location}}', ['service_id', 'tariff_id', 'country_id', 'region_id', 'city_id' ]);


        $this->createTable('{{%services_lang}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(6),
            'label' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%services}}');
    }
}
