<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tariff}}`.
 */
class m200819_111458_create_tariff_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tariff}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'tariff_type_id' => $this->integer(),
            'tariffication_type_id' => $this->integer(),
            'monthly' => $this->smallInteger(1)->defaultValue(1),
            'random' => $this->integer(),
            'works' => $this->smallInteger(1)->defaultValue(1),
            'is_internet' => $this->smallInteger(1),
            'internet_type' => $this->smallInteger(1)->defaultValue(0)->comment('0 => speed, 1 => traffic volume'),
            'internet_id' => $this->integer(),
            'is_tv' => $this->smallInteger(1),
            'tv_packet_id' => $this->integer(),
            'create_at' => $this->dateTime(),
            'update_at' => $this->dateTime(),
        ]);

        $this->createTable('{{%internet}}', [
            'id' => $this->primaryKey(),
            'speed' => $this->integer(),
            'inet_speed_unit_id' => $this->integer(),
            'size' => $this->integer(),
            'inet_size_unit_id' => $this->integer(),
            'type' => $this->smallInteger(1)
        ]);


        $this->createTable('{{%tv_channel}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'cost_price' => $this->float(10, 2),
            'amount' => $this->float(10, 2),
            'active' => $this->smallInteger(1)->defaultValue(1),
            'password' => $this->smallInteger()->defaultValue(0),
        ]);
        $this->addColumn('units', 'type', $this->smallInteger(3));

        $this->createTable('{{%tv_channel_lang}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(6),
            'name' => $this->string(),
        ]);

        $this->createTable('{{%tv_packet_channel}}',[
            'packet_id' => $this->integer(),
            'channel_id' => $this->integer(),
            'price'  => $this->smallInteger(1)->defaultValue(0)

         ]);

        $this->addPrimaryKey('packet_channel_pk', '{{%tv_packet_channel}}', ['packet_id', 'channel_id']);

        $this->createTable('{{%tv_packet}}',[
            'id' => $this->primaryKey(),
            'name' => $this->string(),

        ]);

        $this->createTable('{{%tv_packet_lang}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(6),
            'name' => $this->string(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tariff}}');
    }
}
