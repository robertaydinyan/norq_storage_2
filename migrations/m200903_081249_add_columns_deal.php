<?php

use yii\db\Migration;

/**
 * Class m200903_081249_add_columns_deal
 */
class m200903_081249_add_columns_deal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_deal', 'date_finish', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200903_081249_add_columns_deal cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200903_081249_add_columns_deal cannot be reverted.\n";

        return false;
    }
    */
}
