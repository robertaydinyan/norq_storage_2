<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%shipping}}`.
 */
class m210719_105319_add_status_column_to_shipping_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%s_shipping}}', 'status', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%s_shipping}}', 'status');
    }
}
