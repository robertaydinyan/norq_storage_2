<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%b_share}}`.
 */
class m200831_080511_create_b_share_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%b_share}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'start_date' => $this->dateTime(),
            'end_date' => $this->dateTime(),
            'service_id' => $this->integer(),
            'is_personal' => $this-> smallInteger(1)->defaultValue(0),
            'comment' => $this->text()
        ]);

        $this->createTable('{{%b_share_lang}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'language' => $this->string(6),
            'name' => $this->string(),
        ]);

        $this->createTable('{{%b_share_tariff_config}}', [
            'share_id' => $this->integer(),
            'tariff_id' => $this->integer(),
            'share_type' => $this->smallInteger(1)->comment('0 => tv-ip-internet, 1 => price, 2 => free month'),
            'internet_id' => $this->integer(),
            'tv_packet_id' => $this->integer(),
            'ip_address_count' => $this->integer(),
            'share_price_type' => $this->smallInteger(1)->comment('0 => %, 1 => price'),
            'share_price_value' => $this->decimal(10,2),
            'free_month' => $this->integer()

        ]);
        $this->addPrimaryKey('b_share_tariff_config_pk', '{{%b_share_tariff_config}}', ['share_id', 'tariff_id']);

        $this->createTable('{{%b_share_user_config}}', [
            'share_id' => $this->integer(),
            'user_id' => $this->integer()
        ]);
        $this->addPrimaryKey('b_share_user_config_pk', '{{%b_share_user_config}}', ['share_id', 'user_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%b_share}}');
    }
}
