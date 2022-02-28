<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_contacts}}`.
 */
class m201215_123450_create_f_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_contacts}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'lastname' => $this->string(),
            'surname' => $this->string(),
            'phone' => $this->string(),
            'visit_day' => $this->date(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_contacts}}');
    }
}
