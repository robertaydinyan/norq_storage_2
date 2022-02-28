<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%s_shipping_request}}`.
 */
class m210716_110609_create_s_shipping_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%s_shipping_request}}', [
            'id' => $this->primaryKey(),
            'count' => $this->integer()->notNull(),
            'created_at' => $this->string()->notNull(),

            'nomenclature_product_id' => $this->integer()->notNull(),
            'shipping_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%s_shipping_request}}');
    }
}
