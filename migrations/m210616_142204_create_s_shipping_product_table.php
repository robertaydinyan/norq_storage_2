<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%s_shipping_product}}`.
 */
class m210616_142204_create_s_shipping_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%s_shipping_product}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime()->notNull(),

            'shipping_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%s_shipping_product}}');
    }
}
