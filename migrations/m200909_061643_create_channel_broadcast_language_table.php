<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%channel_broadcast_language}}`.
 */
class m200909_061643_create_channel_broadcast_language_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%channel_broadcast_language}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%channel_broadcast_language}}');
    }
}
