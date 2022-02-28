<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%f_zone}}`.
 */
class m210506_143530_drop_address_list_column_from_f_zone_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('f_zone', 'address_list');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
