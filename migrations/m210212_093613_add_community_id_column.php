<?php

use yii\db\Migration;

/**
 * Class m210212_093613_add_community_id_column
 */
class m210212_093613_add_community_id_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('contact_adress', 'community_id', $this->integer()->after('city_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210212_093613_add_community_id_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210212_093613_add_community_id_column cannot be reverted.\n";

        return false;
    }
    */
}
