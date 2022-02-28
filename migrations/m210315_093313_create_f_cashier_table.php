<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_cashier}}`.
 */
class m210315_093313_create_f_cashier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_cashier}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'is_active' => $this->smallInteger(1)->defaultValue(1)->comment('0 => pasiv, 1 => active')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_cashier}}');
    }
}
