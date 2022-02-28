<?php

use yii\db\Migration;

/**
 * Class m201012_081419_add_column_rating
 */
class m201012_081419_add_column_rating extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tasks', 'rating', $this->integer());
        $this->addColumn('tasks', 'updated_at', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201012_081419_add_column_rating cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201012_081419_add_column_rating cannot be reverted.\n";

        return false;
    }
    */
}
