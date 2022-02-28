<?php

use yii\db\Migration;

/**
 * Class m210302_144023_add_deal_id_column
 */
class m210302_144023_add_deal_id_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal_ballance', 'deal_id', $this->integer()->after('deal_number') );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210302_144023_add_deal_id_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210302_144023_add_deal_id_column cannot be reverted.\n";

        return false;
    }
    */
}
