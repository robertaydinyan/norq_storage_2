<?php

use yii\db\Migration;

/**
 * Class m210219_115157_add_active_column
 */
class m210219_115157_add_active_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_deal', 'is_active', $this->smallInteger(1)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210219_115157_add_active_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210219_115157_add_active_column cannot be reverted.\n";

        return false;
    }
    */
}
