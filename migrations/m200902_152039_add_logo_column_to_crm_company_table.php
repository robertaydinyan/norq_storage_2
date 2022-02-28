<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%crm_company}}`.
 */
class m200902_152039_add_logo_column_to_crm_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_company', 'logo', $this->string());
        $this->addColumn('crm_company', 'company_type_id', $this->integer());
        $this->addColumn('crm_company', 'company_scope_id', $this->integer());
        $this->addColumn('crm_company', 'annual_turnover', $this->decimal(10,2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
