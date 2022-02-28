<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_vacation_options}}`.
 */
class m210419_154913_create_f_vacation_options_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_vacation_options}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_vacation_options}}');
    }
}
