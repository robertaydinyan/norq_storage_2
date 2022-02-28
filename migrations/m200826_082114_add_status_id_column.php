<?php

use yii\db\Migration;

/**
 * Class m200826_082114_add_status_id_column
 */
class m200826_082114_add_status_id_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_lead', 'status_id', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200826_082114_add_status_id_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200826_082114_add_status_id_column cannot be reverted.\n";

        return false;
    }
    */
}
