<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_disruption_options}}`.
 */
class m210419_154952_create_f_disruption_options_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_disruption_options}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_disruption_options}}');
    }
}
