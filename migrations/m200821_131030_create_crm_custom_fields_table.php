<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_custom_fields}}`.
 */
class m200821_131030_create_crm_custom_fields_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_custom_fields}}', [
            'id' => $this->primaryKey(),
            'section_id' => $this->integer(),
            'field_type_id' => $this->integer(),
            'name' => $this->string(),
            'label' => $this->string(),
            'status' => $this->smallInteger(2),
            'required' => $this->smallInteger(1)->defaultValue(0)->comment('0 => not required, 1 => required')
        ]);

        $this->createTable('{{%crm_custom_fields_lang}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(6),
            'label' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%crm_custom_fields}}');
    }
}
