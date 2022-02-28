<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact_adress}}`.
 */
class m200902_152952_create_contact_adress_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact_adress}}', [
            'id' => $this->primaryKey(),
            'contact_id' => $this->integer(),
            'company_id' => $this->integer(),
            'country_id' => $this->integer(),
            'region_id' => $this->integer(),
            'city_id' => $this->integer(),
            'street' => $this->string(),
            'house' => $this->string(),
            'housing' => $this->string(),
            'apartment' => $this->string(),

        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contact_adress}}');
    }
}
