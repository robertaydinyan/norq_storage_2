<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%s_comlectation}}`.
 */
class m210920_060817_create_s_comlectation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%s_comlectation}}', [
            'id' => $this->primaryKey(),

            'new_product_price' =>$this->float(),
            'service_fee' =>$this->float(),
            'new_product_count' =>$this->integer(),
            'created_at' => $this->dateTime(),

            'nomenclature_product_id' => $this->integer()->notNull(),
            'provider_warehouse_id' => $this->integer()->notNull(),
            'supplier_warehouse_id' => $this->integer()->notNull(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%s_comlectation}}');
    }
}
