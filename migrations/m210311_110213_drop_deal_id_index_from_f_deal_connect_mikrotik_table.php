<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%deal_id_index_from_f_deal_connect_mikrotik}}`.
 */
class m210311_110213_drop_deal_id_index_from_f_deal_connect_mikrotik_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex('deal_id', '{{%f_deal_connect_mikrotik}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
