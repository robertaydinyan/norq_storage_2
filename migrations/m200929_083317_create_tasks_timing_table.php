<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks_timing}}`.
 */
class m200929_083317_create_tasks_timing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks_timing}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'planning_start' => $this->dateTime(),
            'planning_end' => $this->dateTime(),
            'real_start' => $this->dateTime(),
            'real_end' => $this->dateTime(),
            'dead_line' => $this->dateTime(),
            'time_track_start' => $this->dateTime(),
            'time_track_actual_duration' => $this->integer(),
            'time_track_planned_duration' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tasks_timing}}');
    }
}
