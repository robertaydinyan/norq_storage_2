<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%lead_status}}`.
 */
class m200826_082246_create_lead_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_status}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'menu_id' => $this->integer()
        ]);

        $this->createTable('{{%crm_status_lang}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(6),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%lead_status}}');
    }
}
