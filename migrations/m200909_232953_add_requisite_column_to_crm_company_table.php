<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%crm_company}}`.
 */
class m200909_232953_add_requisite_column_to_crm_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_company', 'passport_number', $this->string());
        $this->addColumn('crm_company', 'visible_by', $this->string()->comment('Кем виден'));
        $this->addColumn('crm_company', 'when_visible', $this->dateTime()->comment('Когда виден'));
        $this->addColumn('crm_company', 'valid_until', $this->dateTime()->comment('Действителен до'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('crm_company', 'passport_number');
        $this->dropColumn('crm_company', 'visible_by');
        $this->dropColumn('crm_company', 'when_visible');
        $this->dropColumn('crm_company', 'valid_until');
    }
}
