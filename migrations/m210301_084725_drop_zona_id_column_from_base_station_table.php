<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%base_station}}`.
 */
class m210301_084725_drop_zona_id_column_from_base_station_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('f_base_station', 'zona_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
