<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_tarrif}}`.
 */
class m201214_081112_create_f_tarrif_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_tariff}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'availability' => $this->integer(),
            'inet_speed' => $this->integer(),
            'inet_price' => $this->decimal(10,2),
            'tv_id' => $this->integer(),
            'ip_count' => $this->integer(),
            'type' => $this->smallInteger()->defaultValue(0)->comment('0 => tan hamar, 1 => bussiness'),
            'create_at' => $this->dateTime(),
            'update_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_tarrif}}');
    }
}
