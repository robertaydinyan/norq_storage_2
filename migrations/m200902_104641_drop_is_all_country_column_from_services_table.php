<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%services}}`.
 */
class m200902_104641_drop_is_all_country_column_from_services_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('services', 'is_all_country');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
