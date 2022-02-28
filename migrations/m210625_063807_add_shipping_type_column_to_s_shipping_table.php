<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%s_shipping}}`.
 */
class m210625_063807_add_shipping_type_column_to_s_shipping_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%s_shipping}}', 'shipping_type', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%s_shipping}}', 'shipping_type');
    }
}
