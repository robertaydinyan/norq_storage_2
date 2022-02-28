<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_data}}`.
 */
class m201216_131250_create_f_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_data}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'base_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_data}}');
    }
}
