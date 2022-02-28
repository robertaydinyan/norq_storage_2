<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%crm_contact}}`.
 */
class m200908_142812_add_requisite_column_to_crm_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('crm_contact', 'passport_number', $this->string());
        $this->addColumn('crm_contact', 'visible_by', $this->string()->comment('Кем виден'));
        $this->addColumn('crm_contact', 'when_visible', $this->dateTime()->comment('Когда виден'));
        $this->addColumn('crm_contact', 'valid_until', $this->dateTime()->comment('Действителен до'));
        $this->addColumn('crm_contact', 'is_provider', $this->smallInteger()->comment('0, 1'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('crm_contact', 'passport_number');
        $this->dropColumn('crm_contact', 'visible_by');
        $this->dropColumn('crm_contact', 'when_visible');
        $this->dropColumn('crm_contact', 'valid_until');
        $this->dropColumn('crm_contact', 'is_provider');
    }
}
