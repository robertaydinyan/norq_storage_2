<?php

use yii\db\Migration;

/**
 * Class m201214_144430_create_status_column
 */
class m201214_144430_create_status_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_tariff','status', $this->smallInteger(1)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201214_144430_create_status_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201214_144430_create_status_column cannot be reverted.\n";

        return false;
    }
    */
}
