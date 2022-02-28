<?php

use yii\db\Migration;

/**
 * Class m200902_102459_add_status_id_ordering_column
 */
class m200902_102459_add_status_id_ordering_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_deal', 'status_id', $this->integer());
        $this->addColumn('crm_deal', 'ordering', $this->integer()->defaultValue(-1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200902_102459_add_status_id_ordering_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200902_102459_add_status_id_ordering_column cannot be reverted.\n";

        return false;
    }
    */
}
