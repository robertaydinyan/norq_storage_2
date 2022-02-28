<?php

use yii\db\Migration;

/**
 * Class m200910_112940_add_columns_deal_connect
 */
class m200910_112940_add_columns_deal_connect extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('deal_conect', 'location', $this->string());
        $this->addColumn('deal_conect', 'area', $this->string());
        $this->addColumn('deal_conect', 'product_price', $this->decimal(10,2));
        $this->addColumn('deal_conect', 'product_unit_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200910_112940_add_columns_deal_connect cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200910_112940_add_columns_deal_connect cannot be reverted.\n";

        return false;
    }
    */
}
