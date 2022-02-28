<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%crm_company}}`.
 */
class m200916_094605_add_username_column_to_crm_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_company', 'username', $this->string()->null()->after('name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('crm_company', 'username');
    }
}
