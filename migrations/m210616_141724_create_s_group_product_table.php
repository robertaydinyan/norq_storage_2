<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%s_group_product}}`.
 */
class m210616_141724_create_s_group_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%s_group_product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),

            'group_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%s_group_product}}');
    }
}
