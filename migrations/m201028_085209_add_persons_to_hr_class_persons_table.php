<?php

use yii\db\Migration;

/**
 * Class m201028_085209_add_persons_to_hr_class_persons_table
 */
class m201028_085209_add_persons_to_hr_class_persons_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201028_085209_add_persons_to_hr_class_persons_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201028_085209_add_persons_to_hr_class_persons_table cannot be reverted.\n";

        return false;
    }
    */
}
