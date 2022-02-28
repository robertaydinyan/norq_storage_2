<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%f_deal}}`.
 */
class m210223_113601_drop_local_ip_column_from_f_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('f_deal', 'local_ip');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
