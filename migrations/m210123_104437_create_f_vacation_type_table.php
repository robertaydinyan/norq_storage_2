<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_vacation_type}}`.
 */
class m210123_104437_create_f_vacation_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_vacation_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_vacation_type}}');
    }
}
