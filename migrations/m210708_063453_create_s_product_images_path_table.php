<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%images_path}}`.
 */
class m210708_063453_create_s_product_images_path_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%s_product_images_path}}', [
            'id' => $this->primaryKey(),
            'images_path' => $this->string()->notNull(),

            'product_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%s_product_images_path}}');
    }
}
