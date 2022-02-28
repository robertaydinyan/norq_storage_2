<?php

use yii\db\Migration;

/**
 * Class m200903_171806_create_month_base_id_column_to_crm_product
 */
class m200903_171806_create_month_base_id_column_to_crm_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_product', 'month_base_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200903_171806_create_month_base_id_column_to_crm_product cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200903_171806_create_month_base_id_column_to_crm_product cannot be reverted.\n";

        return false;
    }
    */
}
