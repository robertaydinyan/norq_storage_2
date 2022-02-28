<?php

namespace app\modules\crm\models;


use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "crm_company".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $username
 * @property int|null $responsible_id
 * @property string|null $logo
 * @property int|null $company_type_id
 * @property int|null $company_scope_id
 * @property float|null $annual_turnover
 * @property int|null $currency_id
 * @property string|null $passport_number
 * @property string|null $visible_by
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $when_visible
 * @property string|null $valid_until
 * @property int|null $is_provider
 * @property string|null $create_at
 * @property string|null $update_at
 */
class Company extends \yii\db\ActiveRecord
{


    public $company_id;
    public $phoneType;
    public $emailType;
    public $contact_id;
    public $country_id;
    public $community_id;
    public $region_id;
    public $city_id;
    public $street;
    public $house;
    public $housing;
    public $apartment;
    public $passport_img;
    public $id_card;
    public $phone;
    public $surname;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['currency_id', 'responsible_id', 'company_type_id', 'company_scope_id'], 'integer'],
            [['create_at', 'update_at', 'phone', 'email', 'company_id', 'phoneType', 'emailType',
                'street', 'house', 'housing', 'apartment', 'annual_turnover','company_id', 'passport_img', 'id_card',
                'when_visible', 'valid_until', 'country_id' ,'region_id', 'city_id', 'phone', 'surname'], 'safe'],
            ['email', 'email'],
            ['email', 'filter', 'filter' => 'trim'],
            [['name', 'logo', 'passport_number', 'visible_by', 'username'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Անվանում'),
            'username' => Yii::t('app', 'Username'),
            'phone' => Yii::t('app', 'Հեռախոս'),
            'email' => Yii::t('app', 'Էլ․ հասցե'),
            'passport_number' => Yii::t('app', 'ՀՎՀՀ'),
            'passport_img' => Yii::t('app', 'Անձնագրի նկար'),
            'visible_by' => Yii::t('app', 'Ում կողմից'),
            'when_visible' => Yii::t('app', 'Երբ է տրվել'),
            'valid_until' => Yii::t('app', 'Ուժի մեջ է մինչև'),
            'id_card' => Yii::t('app', 'ID карта'),
            'is_provider' => Yii::t('app', 'Պրովայդեր'),
            'create_at' => Yii::t('app', 'Գրանցման ամս․'),
            'update_at' => Yii::t('app', 'Թարմացվել է'),
            'responsible_id' => Yii::t('app', 'Պատասխանատու'),
            'logo' => Yii::t('app', 'Լոգո'),
            'company_type_id' => Yii::t('app', 'Տիպ'),
            'company_scope_id' => Yii::t('app', 'Գործունեության ոլորտը'),
            'annual_turnover' => Yii::t('app', 'Տարեկան շրջանառությունը'),
            'currency_id' => Yii::t('app', 'Ид. валюты'),
            'region_id'=> Yii::t('app', 'Մարզ'),
            'city_id'=> Yii::t('app', 'Շրջան'),
            'street'=> Yii::t('app', 'Փողոց'),
            'house'=> Yii::t('app', 'Տուն'),
            'housing'=> Yii::t('app', 'Կորպուս'),
            'apartment' => Yii::t('app', 'Բնակարան'),
            'community_id'=> Yii::t('app', 'Համայնք'),
            'country_id'=> Yii::t('app', 'Երկիր'),
        ];
    }



    /**
     * @return array|array[]
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT => ['create_at', 'update_at'],
                    self::EVENT_BEFORE_UPDATE => 'update_at',
                ],
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    public function getAllContact()
    {

        return ArrayHelper::map(Company::find()->all(),'id', 'name');

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactAddress()
    {
        return $this->hasMany(ContactAdress::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasMany(ContactCompany::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequisiteFiles()
    {
        return $this->hasMany(CompanyDocument::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeal()
    {
        return $this->hasMany(Deal::className(), ['contact_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyPhone()
    {
        return $this->hasMany(ContactPhone::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStartDeal()
    {
        return $this->hasMany(Deal::className(), ['company_id' => 'id'])
            ->andOnCondition(['start_deal' => 1]);
    }

    /**
     * @return array
     */
    public static function getListForSearch()
    {
        $list =  Company::find()->all();
        $new_list = [];
        if(!empty($list)) {
            foreach ($list as $el => $val) {
                $new_list[$el]['value'] = $val->id;
                $new_list[$el]['name'] = $val->name;
            }
        }
        return $new_list;
    }

    /**
     * @return string
     */
    public function formatedAddress($lastElement = false) {
        $addresses = [];

        if (!empty($this->contactAddress)) {
            foreach ($this->contactAddress as $address) {
                $region = !empty($address->region->name) ? $address->region->name : '';

                $community = '';
                $city = '';
                $house = '';
                $apartment = '';

                if (!empty($address->community)) {
                    $community .= ', հ․ ' . $address->community->name;
                } else {
                    if (!empty($address->city)) {
                        if ($address->city->city_type_id == 1) {
                            $city .= ', ք․ ';
                        } elseif ($address->city->city_type_id == 3) {
                            $city .= ', գ․ ';
                        }

                        $city .= $address->city->name;
                    }
                }

                $street = !empty($address->fastStreet) ? ', փ․ ' . $address->fastStreet->name : '';

                if (!empty($address->house)) {
                    if (!empty($address->apartment)) {
                        $house .= ', շ․ ';
                    } else {
                        $house .= ', տ․ ';
                    }

                    $house .= $address->house;
                }

                if (!empty($address->apartment)) {
                    if ($address->house) {
                        $apartment .= ', բն․ ';
                    } else {
                        $apartment .= ', տ․ ';
                    }

                    $apartment .= $address->apartment;
                }

                $entrance = !empty($address->housing) && !empty($address->apartment) && !empty($address->house) ? ', մ․ ' . $address->housing : '';
                $addresses[] = $region . $community . $city . $street . $house . $entrance . $apartment;
            }
        }

        if ($lastElement) {
            return end($addresses);
        } else {
            return Html::tag('div', StringHelper::truncate(implode(",<br>", $addresses), 100), ['title' => implode(",", $addresses), 'data-toggle' => 'tooltip', 'data-placement' => 'top']);
        }

    }
}
