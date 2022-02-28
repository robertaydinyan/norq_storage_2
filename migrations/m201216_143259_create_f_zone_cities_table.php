<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_zone_cities}}`.
 */
class m201216_143259_create_f_zone_cities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_zone_cities}}', [
            'id' => $this->primaryKey(),
            'zone_id' => $this->integer(),
            'city_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_zone_cities}}');
    }
}
