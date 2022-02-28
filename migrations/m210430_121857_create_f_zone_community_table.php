<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_zone_community}}`.
 */
class m210430_121857_create_f_zone_community_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_zone_community}}', [
            'id' => $this->primaryKey(),
            'zone_id' => $this->integer(),
            'community_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_zone_community}}');
    }
}
