<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%internet}}`.
 */
class m200907_105459_add_min_table_column_to_internet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('internet', 'min_speed', $this->integer());
        $this->addColumn('internet', 'inet_min_speed_unit_id', $this->integer());
        $this->addColumn('internet', 'reset_speed_type', $this->smallInteger()->defaultValue(0));
        $this->addColumn('internet', 'reset_speed', $this->integer());
        $this->addColumn('internet', 'reset_speed_unit_id', $this->integer());
        $this->addColumn('internet', 'size_empty_type', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
