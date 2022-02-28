<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cron}}`.
 */
class m200924_130329_createCron_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cron}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'start' => $this->dateTime(),
            'end' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cron}}');
    }
}
