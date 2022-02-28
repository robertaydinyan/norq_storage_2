<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%channel_category_lang}}`.
 */
class m200909_081855_create_channel_category_lang_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%channel_category_lang}}', [
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
        $this->dropTable('{{%channel_category_lang}}');
    }
}
