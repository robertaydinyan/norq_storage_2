<?php

use yii\db\Migration;

/**
 * Class m210203_135938_rename_deal_id_column
 */
class m210203_135938_rename_deal_id_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('crm_deal_vacation', 'deal_id','deal_number');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210203_135938_rename_deal_id_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210203_135938_rename_deal_id_column cannot be reverted.\n";

        return false;
    }
    */
}
