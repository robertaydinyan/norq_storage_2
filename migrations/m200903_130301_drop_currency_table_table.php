<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%currency_table}}`.
 */
class m200903_130301_drop_currency_table_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%currency_table}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%currency_table}}', [
            'id' => $this->primaryKey(),
        ]);
    }
}
