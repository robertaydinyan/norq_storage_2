<?php

use yii\db\Migration;

/**
 * Class m210204_122710_remove_column_base_id_f_data_table
 */
class m210204_122710_remove_column_base_id_f_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('f_data', 'base_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210204_122710_remove_column_base_id_f_data_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210204_122710_remove_column_base_id_f_data_table cannot be reverted.\n";

        return false;
    }
    */
}
