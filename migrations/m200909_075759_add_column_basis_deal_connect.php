<?php

use yii\db\Migration;

/**
 * Class m200909_075759_add_column_basis_deal_connect
 */
class m200909_075759_add_column_basis_deal_connect extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('deal_conect', 'basis', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200909_075759_add_column_basis_deal_connect cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200909_075759_add_column_basis_deal_connect cannot be reverted.\n";

        return false;
    }
    */
}
