<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%f_deal_connect_mikrotik}}`.
 */
class m210226_075416_add_id_column_to_f_deal_connect_mikrotik_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      //  $this->addColumn('f_deal_connect_mikrotik', 'id', $this->primaryKey()->first());
       // $this->addColumn('f_deal_connect_mikrotik', 'micro_queue_id', $this->string()->after('mikrotik_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
