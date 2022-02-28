<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%f_community}}`.
 */
class m210211_140142_create_f_community_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%f_community}}', [
            'id' => $this->primaryKey(),
            'city_id' => $this->integer(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%f_community}}');
    }
}
