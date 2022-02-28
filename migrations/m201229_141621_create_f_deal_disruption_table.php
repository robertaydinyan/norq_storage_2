<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_deal_disruption}}`.
 */
class m201229_141621_create_f_deal_disruption_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_deal_disruption}}', [
            'id' => $this->primaryKey(),
            'deal_id' => $this->integer(),
            'reason_id' => $this->integer()->defaultValue(null),
            'reason_text' => $this->text()->defaultValue(null),
            'create_at' => $this->dateTime(),
            'update_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_deal_disruption}}');
    }
}
