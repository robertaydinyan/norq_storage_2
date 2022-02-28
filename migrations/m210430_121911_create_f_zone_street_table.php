<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_zone_street}}`.
 */
class m210430_121911_create_f_zone_street_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_zone_street}}', [
            'id' => $this->primaryKey(),
            'zone_id' => $this->integer(),
            'street_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_zone_street}}');
    }
}
