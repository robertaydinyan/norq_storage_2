<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%field_value}}`.
 */
class m200821_135613_create_field_value_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_field_value}}', [
            'id' => $this->primaryKey(),
            'field_id' => $this->integer(),
            'value' => $this->string(),
            'column_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%field_value}}');
    }
}
