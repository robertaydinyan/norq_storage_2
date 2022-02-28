<?php

use yii\db\Migration;

/**
 * Class m200902_085046_add_contact_column
 */
class m200902_085046_add_contact_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_contact', 'surname', $this->string());
        $this->addColumn('crm_contact', 'middle_name', $this->string());
        $this->addColumn('crm_contact', 'image', $this->string());
        $this->addColumn('crm_contact', 'dob', $this->date());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200902_085046_add_contact_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200902_085046_add_contact_column cannot be reverted.\n";

        return false;
    }
    */
}
