<?php

use yii\db\Migration;

/**
 * Class m200910_075316_add_status_type_crm_status_table
 */
class m200910_075316_add_status_type_crm_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_status', 'status_type', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200910_075316_add_status_type_crm_status_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200910_075316_add_status_type_crm_status_table cannot be reverted.\n";

        return false;
    }
    */
}
