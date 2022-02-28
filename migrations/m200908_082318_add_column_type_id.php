<?php

use yii\db\Migration;

/**
 * Class m200908_082318_add_column_type_id
 */
class m200908_082318_add_column_type_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_status', 'type_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200908_082318_add_column_type_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200908_082318_add_column_type_id cannot be reverted.\n";

        return false;
    }
    */
}
