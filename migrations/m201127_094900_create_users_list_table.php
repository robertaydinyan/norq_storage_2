<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_list}}`.
 */
class m201127_094900_create_users_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $data = [
            [
                'Karen',
                Yii::$app->security->generateRandomString(32),
                Yii::$app->security->generatePasswordHash('123123'),
                'moderator1@admin.com',
                10,
                30,
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s"),
            ],
            [
                'Gevorg',
                Yii::$app->security->generateRandomString(32),
                Yii::$app->security->generatePasswordHash('123123'),
                'moderator2@admin.com',
                10,
                30,
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s"),
            ],
            [
                'Vahan',
                Yii::$app->security->generateRandomString(32),
                Yii::$app->security->generatePasswordHash('123123'),
                'moderator3@admin.com',
                10,
                30,
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s"),
            ],
            [
                'Samvel',
                Yii::$app->security->generateRandomString(32),
                Yii::$app->security->generatePasswordHash('123123'),
                'operator1@admin.com',
                10,
                40,
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s"),
            ],
            [
                'Karapet',
                Yii::$app->security->generateRandomString(32),
                Yii::$app->security->generatePasswordHash('123123'),
                'operator2@admin.com',
                10,
                40,
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s"),
            ],
        ];

        $this->batchInsert('user', [
            'username',
            'auth_key',
            'password_hash',
            'email',
            'status',
            'role',
            'created_at',
            'updated_at',
        ],
        $data);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users_list}}');
    }
}
