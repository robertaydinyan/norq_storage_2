<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%f_zone}}`.
 */
class m210406_150806_drop_region_id_column_from_f_zone_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('f_zone', 'region_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
