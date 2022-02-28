<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_product}}`.
 */
class m200826_142915_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_product}}', [
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
        $this->dropTable('{{%crm_product}}');
    }
}
