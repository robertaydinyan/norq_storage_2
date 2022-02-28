<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%base_zones}}`.
 */
class m210211_115216_create_f_base_zones_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_base_zones}}', [
            'base_id' => $this->integer(),
            'zone_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_base_zones}}');
    }
}
