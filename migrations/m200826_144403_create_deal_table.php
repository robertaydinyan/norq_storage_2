<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_deal}}`.
 */
class m200826_144403_create_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_deal}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'create_at' => $this->dateTime(),
            'update_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%crm_deal}}');
    }
}
