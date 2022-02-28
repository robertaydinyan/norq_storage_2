<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_streets}}`.
 */
class m210111_080507_create_f_streets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_streets}}', [
            'id' => $this->primaryKey(),
            'city_id' =>$this->integer()->notNull(),
            'name' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_streets}}');
    }
}
