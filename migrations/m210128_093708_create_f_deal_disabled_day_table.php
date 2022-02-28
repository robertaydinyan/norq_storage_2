<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_deal_disabled_day}}`.
 */
class m210128_093708_create_f_deal_disabled_day_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_deal_disabled_day}}', [
            'id' => $this->primaryKey(),
            'disabled_day' => $this->integer(),
            'disabled_price_day' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_deal_disabled_day}}');
    }
}
