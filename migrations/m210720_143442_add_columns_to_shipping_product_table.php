<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%shipping_product}}`.
 */
class m210720_143442_add_columns_to_shipping_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('{{%s_shipping_product}}', 'product_id', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
