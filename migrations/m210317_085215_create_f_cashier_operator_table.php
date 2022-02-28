<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_cashier_operator}}`.
 */
class m210317_085215_create_f_cashier_operator_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_cashier_operator}}', [
            'cashier_id' => $this->integer(),
            'operator_id' => $this->integer(),
        ]);

        $this->addPrimaryKey('f_cashier_operator-cashier_pk', '{{%f_cashier_operator}}', ['cashier_id', 'operator_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_cashier_operator}}');
    }
}
