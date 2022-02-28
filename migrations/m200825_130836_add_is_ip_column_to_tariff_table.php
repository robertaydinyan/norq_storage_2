<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%tariff}}`.
 */
class m200825_130836_add_is_ip_column_to_tariff_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tariff}}', 'is_ip', $this->integer()->defaultValue(0)->after('tv_packet_id'));
        $this->addColumn('{{%tariff}}', 'ip_id', $this->integer()->after('is_ip'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tariff}}', 'is_ip');
        $this->dropColumn('{{%tariff}}', 'ip_id');
    }
}
