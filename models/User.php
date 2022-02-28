<?php

namespace app\models;

use app\models\query\UserQuery;
use app\modules\crm\models\CashierOperator;
use app\modules\warehouse\models\Warehouse;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property string $access_token
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $ref_password
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @var $password_confirmation
     */
    public $password_confirmation;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    const ROLE_USER = 10;
    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';
    const ROLE_OPERATOR= 'operator';
    const ROLE_TERMINAL= 'terminal';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['username', 'name', 'last_name', 'email'], 'required'],
            [['updated_at', 'created_at', 'role', 'ref_password'], 'safe'],
            [['auth_key', 'access_token'], 'string', 'max' => 255],
            ['password_hash', 'string', 'min' => 6],
            [['password_hash', 'password_confirmation'], 'required', 'on' => 'create'],
            ['password_confirmation', 'compare', 'compareAttribute' => 'password_hash', 'skipOnEmpty' => true]
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->setPassword($this->password_hash);
            $this->auth_key = \Yii::$app->security->generateRandomString();
        } else {
            if (!empty($this->password_hash)) {
                $this->setPassword($this->password_hash);
            } else {
                $this->password_hash = (string) $this->getOldAttribute('password_hash');
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'name' => Yii::t('app', 'Անուն'),
            'last_name' => Yii::t('app', 'Ազգանուն'),
            'email' => Yii::t('app', 'Էլ․ փոստ'),
            'status' => Yii::t('app', 'Ակտիվ'),
            'role' => Yii::t('app', 'Դերը'),
            'password_hash' => Yii::t('app', 'Գաղտնաբառ'),
            'password_confirmation' => Yii::t('app', 'Գաղտնաբառի հաստատում'),
            'created_at' => Yii::t('app', 'Գրանցվել է'),
            'updated_at' => Yii::t('app', 'Թարմացվել է'),

        ];
    }

    /**
     * @return string[]
     */
    public function getRole() {
        return [
            self::ROLE_ADMIN => 'Ադմին',
            self::ROLE_MANAGER => 'Մենեջեր',
            self::ROLE_OPERATOR => 'Օպերատոր',
            self::ROLE_TERMINAL => 'Տերմինալ',
            self::ROLE_USER => 'Օգտատեր',
        ];
    }

    public function getStatus() {
        return [
            self::STATUS_ACTIVE => 'Ակտիվ',
            self::STATUS_DELETED => 'Պասիվ',
        ];
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public static function generateAccessToken() {
        return Yii::$app->security->generateRandomString();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByRole($role)
    {
        return static::find()->where(['role' => $role, 'status' => self::STATUS_ACTIVE])->asArray()->all();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function getWarehouse() {
        return $this->hasMany(Warehouse::className(), ['user_id' => 'id']);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        $this->password_confirmation = $this->password_hash;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @param $user
     * @return User
     * @throws \yii\base\Exception
     */
    public function signUp() {
        if ($this->validate()) {
            $signUp = new User();
            $signUp->username = $this->username;
            $signUp->name = $this->name;
            $signUp->last_name = $this->last_name;
            $signUp->generateAuthKey();
            $signUp->access_token = self::generateAccessToken();
            $signUp->setPassword($this->password_hash);
            $signUp->ref_password = $this->password_hash;
            $signUp->generatePasswordResetToken();
            $signUp->email = $this->email;
            $signUp->status = $this->status;
            $signUp->role = $this->role;

            if ($signUp->save()) {
                return $signUp;
            }
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashierOperator() {
        return $this->hasOne(CashierOperator::className(), ['operator_id' => 'id']);
    }

    /**
     * @return UserQuery|\yii\db\ActiveQuery
     */
    public static function find() {
        return new UserQuery(get_called_class());
    }

    /**
     * @return mixed|null
     */
    public function isCashier() {
        return $this->cashierOperator;
    }

    /**
     * @return bool
     */
    public function isAdmin() {
        return $this->role === 'admin';
    }
}
