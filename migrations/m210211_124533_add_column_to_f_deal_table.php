<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%f_deal}}`.
 */
class m210211_124533_add_column_to_f_deal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal' , 'blacklist', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
