<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m210317_115316_add_name_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'name', $this->string()->after('username'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
