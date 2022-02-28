<?php

use yii\db\Migration;

/**
 * Class m201214_120651_create_speed_for_year_column
 */
class m201214_120651_create_speed_for_year_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_tariff', 'speed_for_year', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201214_120651_create_speed_for_year_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201214_120651_create_speed_for_year_column cannot be reverted.\n";

        return false;
    }
    */
}
