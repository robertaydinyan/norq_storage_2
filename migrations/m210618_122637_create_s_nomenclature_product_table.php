<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%s_nomenclature_product}}`.
 */
class m210618_122637_create_s_nomenclature_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%s_nomenclature_product}}', [
            'id' => $this->primaryKey(),
            'vendor_code' => $this->string(),
            'name' =>$this->string()->notNull(),
            'group' =>$this->string(),
            'production_date' =>$this->date(),
            'type' =>$this->string(),
            'individual' =>$this->string(),
            'qty_type' =>$this->string(),

            'group_id' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%s_nomenclature_product}}');
    }
}
