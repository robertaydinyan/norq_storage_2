<?php

use yii\db\Migration;

/**
 * Class m200909_083230_add_column_tv_channel_table
 */
class m200909_083230_add_column_tv_channel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tv_channel', 'logo_channel', $this->string());
        $this->addColumn('tv_channel', 'channel_category_id', $this->integer());
        $this->addColumn('tv_channel', 'channel_quality_id', $this->integer());
        $this->addColumn('tv_channel', 'provider_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200909_083230_add_column_tv_channel_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200909_083230_add_column_tv_channel_table cannot be reverted.\n";

        return false;
    }
    */
}
