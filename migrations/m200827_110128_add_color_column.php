<?php

use yii\db\Migration;

/**
 * Class m200827_110128_add_color_column
 */
class m200827_110128_add_color_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_status', 'color', $this->text()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200827_110128_add_color_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200827_110128_add_color_column cannot be reverted.\n";

        return false;
    }
    */
}
