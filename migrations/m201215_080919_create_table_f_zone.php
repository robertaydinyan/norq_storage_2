<?php

use yii\db\Migration;

/**
 * Class m201215_080919_create_table_f_zone
 */
class m201215_080919_create_table_f_zone extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_zone}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'country_id' => $this->integer(),
            'region_id' => $this->integer(),
            'city_id' => $this->integer(),
            'address_list' => $this->string()
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_zone}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201215_080919_create_table_f_zone cannot be reverted.\n";

        return false;
    }
    */
}
