<?php

use yii\db\Migration;

/**
 * Class m210123_104656_add_vacation_type_id_to_crm_deal_vacation_table
 */
class m210123_104656_add_vacation_type_id_to_crm_deal_vacation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_deal_vacation', 'vacation_type_id', $this->integer()->after('deal_id')->null());
        $this->addColumn('crm_deal_vacation', 'comment', $this->text()->after('vacation_type_id')->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210123_104656_add_vacation_type_id_to_crm_deal_vacation_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210123_104656_add_vacation_type_id_to_crm_deal_vacation_table cannot be reverted.\n";

        return false;
    }
    */
}
