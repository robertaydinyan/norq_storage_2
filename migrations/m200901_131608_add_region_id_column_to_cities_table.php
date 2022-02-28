<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cities}}`.
 */
class m200901_131608_add_region_id_column_to_cities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('cities', 'region_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
