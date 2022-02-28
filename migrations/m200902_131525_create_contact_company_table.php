<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact_company}}`.
 */
class m200902_131525_create_contact_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact_company}}', [
            'contact_id' => $this->integer(),
            'company_id' => $this->integer(),
        ]);

        $this->addPrimaryKey('contact_company_pk', '{{%contact_company}}', ['contact_id', 'company_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contact_company}}');
    }
}
