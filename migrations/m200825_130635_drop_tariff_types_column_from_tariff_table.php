<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%tariff}}`.
 */
class m200825_130635_drop_tariff_types_column_from_tariff_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%tariff}}', 'tariff_type_id');
        $this->dropColumn('{{%tariff}}', 'tariffication_type_id');
        $this->dropColumn('{{%tariff}}', 'monthly');
        $this->dropColumn('{{%tariff}}', 'random');
        $this->dropColumn('{{%tariff}}', 'works');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
