<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%s_qty_type}}`.
 */
class m210721_091628_create_s_qty_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%s_qty_type}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%s_qty_type}}');
    }
}
