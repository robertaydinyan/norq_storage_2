<?php

use yii\db\Migration;

/**
 * Class m210603_122812_add_download_speed_column
 */
class m210603_122812_add_download_speed_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('f_tariff', 'inet_speed_download', $this->integer()->after('inet_speed'));
        $this->addColumn('f_tariff', 'old_tariff', $this->smallInteger()->defaultValue(0)->after('status'));
        $this->addColumn('f_deal', 'down_binding_speed', $this->integer()->after('binding_speed'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210603_122812_add_download_speed_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210603_122812_add_download_speed_column cannot be reverted.\n";

        return false;
    }
    */
}
