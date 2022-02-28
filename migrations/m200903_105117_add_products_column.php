<?php

use yii\db\Migration;

/**
 * Class m200903_105117_add_products_column
 */
class m200903_105117_add_products_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_product', 'eq_or_sup', $this->smallInteger(1));
        $this->addColumn('crm_product', 'base_amount', $this->integer());
        $this->addColumn('crm_product', 'currency_id', $this->integer());
        $this->addColumn('crm_product', 'count', $this->float());
        $this->addColumn('crm_product', 'unit_id', $this->integer());
        $this->addColumn('crm_product', 'image', $this->string());
        $this->addColumn('crm_product', 'warehouse_id', $this->integer());


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200903_105117_add_products_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200903_105117_add_products_column cannot be reverted.\n";

        return false;
    }
    */
}
