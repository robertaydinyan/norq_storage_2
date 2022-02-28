<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%deal_type}}`.
 */
class m200902_152325_create_deal_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%deal_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);

        $this->createTable('{{%deal_type_lang}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(6),
            'name' => $this->string()
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%deal_type}}');
    }
}
