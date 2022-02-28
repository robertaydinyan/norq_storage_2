<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_deal_sale}}`.
 */
class m210121_064850_create_f_deal_sale_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_deal_sale}}', [
            'id' => $this->primaryKey(),
            'deal_id' => $this->integer(),
            'month' => $this->timestamp(),
            'price' => $this->decimal(10, 2),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_deal_sale}}');
    }
}
