<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%tariff}}`.
 */
class m200907_105917_add_is_active_column_to_tariff_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tariff', 'is_active', $this->boolean()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('tariff', 'is_active');
    }
}
