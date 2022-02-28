<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%f_zone}}`.
 */
class m201216_143603_drop_city_id_column_from_f_zone_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('f_zone', 'city_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('f_zone', 'city_id', $this->integer());
    }
}
