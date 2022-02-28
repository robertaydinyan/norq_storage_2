<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%channel_id_broadcast_id}}`.
 */
class m200909_061932_create_channel_id_broadcast_id_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%channel_id_broadcast_id}}', [
            'id' => $this->primaryKey(),
            'channel_id' => $this->integer(),
            'broadcast_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%channel_id_broadcast_id}}');
    }
}
