<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_data_base}}`.
 */
class m210204_111340_create_f_data_base_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_data_base}}', [
            'id' => $this->primaryKey(),
            'data_id' => $this->integer(),
            'base_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_data_base}}');
    }
}
