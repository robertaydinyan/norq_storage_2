<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_zone_regions}}`.
 */
class m210406_150630_create_f_zone_regions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_zone_regions}}', [
            'id' => $this->primaryKey(),
            'zone_id' => $this->integer(),
            'region_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_zone_regions}}');
    }
}
