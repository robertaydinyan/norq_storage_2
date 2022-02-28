<?php

use yii\db\Migration;

/**
 * Class m201219_135958_add_f_deal_column
 */
class m201219_135958_add_f_deal_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('f_deal', 'discount_id', 'crm_contact_id');
        $this->renameColumn('f_deal', 'share_id', 'crm_company_id');
        $this->addColumn('f_deal', 'connect_price', $this->decimal(10,2)->comment('miacman gumar'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201219_135958_add_f_deal_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201219_135958_add_f_deal_column cannot be reverted.\n";

        return false;
    }
    */
}
