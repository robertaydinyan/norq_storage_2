<?php

use yii\db\Migration;

/**
 * Class m210325_164310_add_required_users_to_user_table
 */
class m210325_164310_add_required_users_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns = ['id', 'username', 'name', 'auth_key', 'access_token', 'password_hash', 'ref_password', 'password_reset_token', 'email', 'status', 'role', 'last_name'];

        $rows = [
            [null, 'ashotfast', 'Աշոտ', \Yii::$app->security->generateRandomString(), null, Yii::$app->security->generatePasswordHash('123123'), '123123', null, 'ashotfast@gmail.com', \app\models\User::STATUS_ACTIVE, \app\models\User::ROLE_ADMIN, 'Ազգանուն'],
            [null, 'telcell', 'TelCell', \Yii::$app->security->generateRandomString(), null, Yii::$app->security->generatePasswordHash('123123'), '123123', null, 'info@telcell.am', \app\models\User::STATUS_ACTIVE, \app\models\User::ROLE_TERMINAL, 'TelCell'],
            [null, 'easypay', 'EasyPay', \Yii::$app->security->generateRandomString(), null, Yii::$app->security->generatePasswordHash('123123'), '123123', null, 'info@easypay.am', \app\models\User::STATUS_ACTIVE, \app\models\User::ROLE_TERMINAL, 'EasyPay'],
            [null, 'haypost', 'HayPost', \Yii::$app->security->generateRandomString(), null, Yii::$app->security->generatePasswordHash('123123'), '123123', null, 'info@haypost.am', \app\models\User::STATUS_ACTIVE, \app\models\User::ROLE_TERMINAL, 'HayPost'],
        ];

        $this->batchInsert('user', $columns, $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210325_164310_add_required_users_to_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210325_164310_add_required_users_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
