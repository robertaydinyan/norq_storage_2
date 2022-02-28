<?php

use yii\db\Migration;

/**
 * Class m210325_123831_alter_role_column_from_user_table
 */
class m210325_123831_alter_role_column_from_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user', 'role', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210325_123831_alter_role_column_from_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210325_123831_alter_role_column_from_user_table cannot be reverted.\n";

        return false;
    }
    */
}
