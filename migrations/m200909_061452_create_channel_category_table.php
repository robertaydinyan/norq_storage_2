<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%channel_category}}`.
 */
class m200909_061452_create_channel_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%channel_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%channel_category}}');
    }
}
