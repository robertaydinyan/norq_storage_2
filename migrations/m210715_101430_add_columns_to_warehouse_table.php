<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%warehouse}}`.
 */
class m210715_101430_add_columns_to_warehouse_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%s_warehouse}}', 'name', $this->string());
        $this->addColumn('{{%s_warehouse}}', 'contact_address_id', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%s_warehouse}}', 'name');
        $this->dropColumn('{{%s_warehouse}}', 'contact_address_id');
    }
}
