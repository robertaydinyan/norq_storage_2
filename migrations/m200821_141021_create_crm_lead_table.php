<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_lead}}`.
 */
class m200821_141021_create_crm_lead_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_lead}}', [
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
        $this->dropTable('{{%crm_lead}}');
    }
}
