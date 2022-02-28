<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%s_shipping}}`.
 */
class m210616_142128_create_s_shipping_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%s_shipping}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime(),

            'provider_warehouse_id' => $this->integer()->notNull(),
            'supplier_warehouse_id' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%s_shipping}}');
    }
}
