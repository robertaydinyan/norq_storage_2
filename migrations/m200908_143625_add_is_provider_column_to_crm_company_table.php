<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%crm_company}}`.
 */
class m200908_143625_add_is_provider_column_to_crm_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_company', 'is_provider', $this->smallInteger()->comment('0, 1'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('crm_company', 'is_provider');
    }
}
