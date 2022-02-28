<?php

use yii\db\Migration;

/**
 * Class m210505_132209_add_community_id_to_f_streets_table
 */
class m210505_132209_add_community_id_to_f_streets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_streets', 'community_id', $this->integer()->after('city_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210505_132209_add_community_id_to_f_streets_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210505_132209_add_community_id_to_f_streets_table cannot be reverted.\n";

        return false;
    }
    */
}
