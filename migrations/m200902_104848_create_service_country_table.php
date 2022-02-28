<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service_country}}`.
 */
class m200902_104848_create_service_country_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_country}}', [
            'service_id' => $this->integer(),
            'country_id' => $this->integer(),
            'region_id' => $this->integer(),
            'city_id' => $this->integer(),
        ]);

        $this->addPrimaryKey('services-service_country_pk', '{{%service_country}}', ['service_id', 'country_id', 'region_id', 'city_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%service_country}}');
        $this->dropPrimaryKey('services-service_country_pk', '{{%service_country}}');
    }
}
