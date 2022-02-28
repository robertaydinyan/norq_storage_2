<?php

use yii\db\Migration;

/**
 * Class m200916_142731_add_column_work_price_crm_deal
 */
class m200916_142731_add_column_work_price_crm_deal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_deal', 'work_price', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200916_142731_add_column_work_price_crm_deal cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200916_142731_add_column_work_price_crm_deal cannot be reverted.\n";

        return false;
    }
    */
}
