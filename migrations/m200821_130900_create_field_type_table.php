<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%field_type}}`.
 */
class m200821_130900_create_field_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_field_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'title' => $this->string(),
            'text' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%crm_field_type}}');
    }
}
