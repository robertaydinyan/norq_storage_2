<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%shipping}}`.
 */
class m210720_142455_add_columns_to_shipping_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%s_shipping_product}}', 'count', $this->integer());
        $this->addColumn('{{%s_shipping_product}}', 'nomenclature_product_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
