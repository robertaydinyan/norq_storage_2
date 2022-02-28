<?php

use yii\db\Migration;

/**
 * Class m200902_151956_add_column_deal_column
 */
class m200902_151956_add_column_deal_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_deal', 'amount', $this->decimal(10,2));
        $this->addColumn('crm_deal', 'currency_id', $this->integer());
        $this->addColumn('crm_deal', 'contact_id', $this->integer());
        $this->addColumn('crm_deal', 'company_id', $this->integer());
        $this->addColumn('crm_deal', 'deal_type_id', $this->integer());
        $this->addColumn('crm_deal', 'responsible_id', $this->integer());
        $this->addColumn('crm_contact', 'responsible_id', $this->integer());
        $this->addColumn('crm_company', 'responsible_id', $this->integer());
        $this->addColumn('crm_lead', 'responsible_id', $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200902_151956_add_column_deal_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200902_151956_add_column_deal_column cannot be reverted.\n";

        return false;
    }
    */
}
