<?php

use yii\db\Migration;

/**
 * Class m210406_124017_alter_last_name_column_from_user_table
 */
class m210406_124017_alter_last_name_column_from_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user', 'last_name', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210406_124017_alter_last_name_column_from_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210406_124017_alter_last_name_column_from_user_table cannot be reverted.\n";

        return false;
    }
    */
}
