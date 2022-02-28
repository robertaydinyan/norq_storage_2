<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%deal_address}}`.
 */
class m200916_064643_create_deal_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%deal_address}}', [
            'id' => $this->primaryKey(),
            'deal_id' => $this->integer(),
            'address_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%deal_address}}');
    }
}
