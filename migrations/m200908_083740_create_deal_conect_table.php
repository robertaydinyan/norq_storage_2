<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%deal_conect}}`.
 */
class m200908_083740_create_deal_conect_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%deal_conect}}', [
            'id' => $this->primaryKey(),
            'deal_id' =>$this->integer(),
            'edit_date' => $this->dateTime(),
            'installer_id' => $this->integer(),
            'eq_type' => $this->smallInteger(2)->comment('1 => Локальное оборудование аренда, 2 => расходные материалы, 3 => Локальное оборудование(продажа), 4 => сетевое оборудование'),
            'product_id' => $this->integer(),
            'count' => $this->integer(),
            'mac_address' => $this->string(),
            'ip_address' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%deal_conect}}');
    }
}
