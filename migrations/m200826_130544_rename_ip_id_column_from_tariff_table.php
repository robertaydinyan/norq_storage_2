<?php

use yii\db\Migration;

/**
 * Class m200826_130544_rename_ip_id_column_from_tariff_table
 */
class m200826_130544_rename_ip_id_column_from_tariff_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('tariff', 'ip_id', 'ip_count');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200826_130544_rename_ip_id_column_from_tariff_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200826_130544_rename_ip_id_column_from_tariff_table cannot be reverted.\n";

        return false;
    }
    */
}
