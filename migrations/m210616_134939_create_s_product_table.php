<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%s_product}}`.
 */
class m210616_134939_create_s_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%s_product}}', [
            'id' => $this->primaryKey(),
            'price' => $this->float(),
            'retail_price' => $this->float(),
            'supplier_name' => $this->string(),
            'mac_address' => $this->string(),
            'comment' => $this->string(),
            'used' => $this->string(),
            'created_at' => $this->string()->notNull(),

            'warehouse_id' => $this->integer()->notNull(),
            'nomenclature_product_id' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%s_product}}');
    }
}
