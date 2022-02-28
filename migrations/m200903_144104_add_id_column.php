<?php

use yii\db\Migration;

/**
 * Class m200903_144104_add_id_column
 */
class m200903_144104_add_id_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('service_country', 'id', $this->primaryKey());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200903_144104_add_id_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200903_144104_add_id_column cannot be reverted.\n";

        return false;
    }
    */
}
