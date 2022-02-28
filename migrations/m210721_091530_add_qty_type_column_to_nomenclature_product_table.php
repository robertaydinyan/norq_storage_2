<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%nomenclature_product}}`.
 */
class m210721_091530_add_qty_type_column_to_nomenclature_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%s_nomenclature_product}}', 'qty_type_id', $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
