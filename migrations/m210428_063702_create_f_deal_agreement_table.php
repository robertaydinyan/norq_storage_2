<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_deal_agreement}}`.
 */
class m210428_063702_create_f_deal_agreement_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_deal_agreement}}', [
            'id' => $this->primaryKey(),
            'deal_id' => $this->integer(),
            'file' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_deal_agreement}}');
    }
}
