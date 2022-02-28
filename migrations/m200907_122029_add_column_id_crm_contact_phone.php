<?php

use yii\db\Migration;

/**
 * Class m200907_122029_add_column_id_crm_contact_phone
 */
class m200907_122029_add_column_id_crm_contact_phone extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_contact_phone', 'id', $this->primaryKey());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200907_122029_add_column_id_crm_contact_phone cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200907_122029_add_column_id_crm_contact_phone cannot be reverted.\n";

        return false;
    }
    */
}
