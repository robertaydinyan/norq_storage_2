<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%internet}}`.
 */
class m200825_131749_drop_type_column_from_internet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%internet}}', 'type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
