<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%channel_quality}}`.
 */
class m200909_061603_create_channel_quality_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%channel_quality}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%channel_quality}}');
    }
}
