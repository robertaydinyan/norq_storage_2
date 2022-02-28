<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%s_comlectation_shipping}}`.
 */
class m210920_062617_create_s_comlectation_shipping_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%s_complectation_shipping}}', [
            'id' => $this->primaryKey(),
            'n_product_count' => $this->integer(),

            'complectation_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%s_comlectation_shipping}}');
    }
}
