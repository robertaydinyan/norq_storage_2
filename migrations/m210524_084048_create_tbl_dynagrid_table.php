<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tbl_dynagrid}}`.
 */
class m210524_084048_create_tbl_dynagrid_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "CREATE TABLE `tbl_dynagrid` (
              `id` varchar(100) NOT NULL COMMENT 'Unique dynagrid setting identifier',
              `filter_id` varchar(100) COMMENT 'Filter setting identifier',
              `sort_id` varchar(100) COMMENT 'Sort setting identifier',
              `data` varchar(5000) DEFAULT NULL COMMENT 'Json encoded data for the dynagrid configuration',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Dynagrid personalization configuration settings'";

        Yii::$app->db->createCommand($sql)->execute();

        $sql2 = "CREATE TABLE `tbl_dynagrid_dtl` (
              `id` varchar(100) NOT NULL COMMENT 'Unique dynagrid detail setting identifier',
              `category` varchar(10) NOT NULL COMMENT 'Dynagrid detail setting category filter or sort',
              `name` varchar(150) NOT NULL COMMENT 'Name to identify the dynagrid detail setting',
              `data` varchar(5000) DEFAULT NULL COMMENT 'Json encoded data for the dynagrid detail configuration',
              `dynagrid_id` varchar(100) NOT NULL COMMENT 'Related dynagrid identifier',
              PRIMARY KEY (`id`),
              UNIQUE KEY `tbl_dynagrid_dtl_UK1` (`name`,`category`,`dynagrid_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Dynagrid detail configuration settings'";

        Yii::$app->db->createCommand($sql2)->execute();

        $sql3 = "ALTER TABLE `tbl_dynagrid`
                ADD CONSTRAINT `tbl_dynagrid_FK1` 
                FOREIGN KEY (`filter_id`) 
                REFERENCES `tbl_dynagrid_dtl` (`id`) 
                , ADD INDEX `tbl_dynagrid_FK1` (`filter_id` ASC);
                 
                ALTER TABLE `tbl_dynagrid`
                ADD CONSTRAINT `tbl_dynagrid_FK2` 
                FOREIGN KEY (`sort_id`) 
                REFERENCES `tbl_dynagrid_dtl` (`id`) 
                , ADD INDEX `tbl_dynagrid_FK2` (`sort_id` ASC);";

        Yii::$app->db->createCommand($sql3)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tbl_dynagrid}}');
        $this->dropTable('{{%tbl_dynagrid_dtl}}');
    }
}
