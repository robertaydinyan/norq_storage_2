<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%crm_contact}}`.
 */
class m200916_094558_add_username_column_to_crm_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_contact', 'username', $this->string()->null()->after('name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('crm_contact', 'username');
    }
}
