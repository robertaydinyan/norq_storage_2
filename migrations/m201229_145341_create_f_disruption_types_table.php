<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_disruption_types}}`.
 */
class m201229_145341_create_f_disruption_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_disruption_types}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_disruption_types}}');
    }
}
