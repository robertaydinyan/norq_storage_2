<?php

namespace app\modules\crm\models;

use app\models\User;
use app\modules\crm\models\query\CashierQuery;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "f_cashier".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $is_active 0 => pasiv, 1 => active
 * @property int|null $blacklist 0 => black, 1 => white
 * @property int|null $virtual 0 => Not virtual, 1 => Virtual
 */
class Cashier extends \yii\db\ActiveRecord
{
    public $operator_id;

    /**
     * Cashier statuses.
     */
    const INACTIVE = 0;
    const ACTIVE = 1;

    /**
     * Cashier blacklist statuses.
     */
    const BLACKLIST_BLACK = 0;
    const BLACKLIST_WHITE = 1;

    /**
     * Cashier is virtual statuses.
     */
    const NOT_VIRTUAL = 0;
    const VIRTUAL = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_cashier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active', 'blacklist', 'virtual'], 'integer'],
            [['is_active'], 'default', 'value' => 1],
            [['name'], 'string', 'max' => 255],
            [['operator_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Դրամարկղ',
            'is_active' => 'Ակտիվ',
            'operator_id' => 'Աշխատակից',
            'blacklist' => 'Հաշվապահություն',
            'virtual' => 'Virtual',
        ];
    }

    /**
     * @return CashierQuery
     */
    public static function find() {
        return new CashierQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getOperator() {
        return $this->hasOne(User::className(), ['id' => 'operator_id'])
            ->viaTable(CashierOperator::tableName(), ['cashier_id' => 'id']);
    }

    public function getCashierOperator() {
        return $this->hasOne(CashierOperator::className(), ['cashier_id' => 'id']);
    }

    /**
     * @param null $id
     * @return array
     */
    public static function getBusyOperators($id = null) {


        if (!is_null($id)) {
            $busyOperators = CashierOperator::find()->select('operator_id')->where(['!=', 'operator_id', $id])->asArray()->all();
        } else {
            $busyOperators = CashierOperator::find()->select('operator_id')->asArray()->all();
        }

        $indexById = [];

        if (!empty($busyOperators)) {
            foreach ($busyOperators as $busyOperator) {
                $indexById[] = $busyOperator['operator_id'];
            }
        }

        return $indexById;
    }

    /**
     * @param null $selected
     * @return array
     */
    public function select2Data($selected = null) {
        return ArrayHelper::map(User::find()
            ->availableOperatorsForCashier(self::getBusyOperators($selected))
            ->all(), 'id', function ($user) {
            return $user->name . ' ' . $user->last_name;
        });
    }

    /**
     * @return array
     */
    public function getContactList(){

        $res = User::findAll();
        return ArrayHelper::map($res,'id', 'name');
    }

}
