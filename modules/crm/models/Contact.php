<?php

namespace app\modules\crm\models;

use app\modules\billing\models\query\ContactQuery;

use borales\extensions\phoneInput\PhoneInputValidator;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "crm_contact".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $username
 * @property string|null $surname
 * @property string|null $middle_name
 * @property string|null $image
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $dob
 * @property string|null $passport_number
 * @property string|null $visible_by
 * @property string|null $when_visible
 * @property string|null $valid_until
 * @property string|null $create_at
 * @property string|null $update_at
 */
class Contact extends \yii\db\ActiveRecord
{

    public $company_id;
    public $phoneType;
    public $emailType;
    public $country_id;
    public $community_id;
    public $phone;
    public $email_id;
    public $region_id;
    public $city_id;
    public $street;
    public $house;
    public $housing;
    public $apartment;
    public $id_card;
    public $passport_img;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['name', 'surname', 'passport_number'], 'required'],
            [['create_at', 'update_at','dob', 'middle_name', 'surname', 'phoneType', 'emailType', 'phone', 'when_visible', 'valid_until', 'country_id',
                'region_id', 'city_id', 'email', 'street', 'house', 'housing', 'apartment', 'company_id',  'id_card', 'community_id'], 'safe'],
            [['name', 'passport_number', 'visible_by', 'username'], 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'filter', 'filter' => 'trim'],
            [['is_provider'], 'integer'],
        //    [['contactPassport', 'id_card'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize' => 1024 * 1024 * 20]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Անուն'),
            'username' => Yii::t('app', 'Օգտատերի անուն'), // petq chi
            'surname' => Yii::t('app', 'Ազգանուն'),
            'middle_name' => Yii::t('app', 'Հայրանուն'),
            'dob' => Yii::t('app', 'Ծննդյան ամսաթիվ'),
            'phone' => Yii::t('app', 'Телефон'),
            'email' => Yii::t('app', 'E-mail'),
            'company_id' => Yii::t('app', 'Компании, связанные с контактом'), // petq chi
            'passport_number' => Yii::t('app', 'Անձնագրի սերիա'),
            'visible_by' => Yii::t('app', 'ՈՒմ կողմից'),
            'when_visible' => Yii::t('app', 'Երբ է տրվել'),
            'valid_until' => Yii::t('app', 'Ուժի մեջ է մինչև'),
            'id_card' => Yii::t('app', 'ID CARD'),
            'is_provider' => Yii::t('app', 'Провайдер'), // petq chi
            'create_at' => Yii::t('app', 'Ստեղծվել է'),
            'update_at' => Yii::t('app', 'Թարմացվել է'),
            'image' => Yii::t('app', 'Изображение'),
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
    public function getStartDeal()
    {
        return $this->hasMany(Deal::className(), ['contact_id' => 'id'])
            ->andOnCondition(['start_deal' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasMany(ContactCompany::className(), ['contact_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequisiteFiles()
    {
        return $this->hasMany(ContactPassport::className(), ['contact_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getAllCompany(){
        return ArrayHelper::map(Company::find()->all(),'id', 'name');
    }

    /**
     * @return array
     */
    public static function getClientsList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getContacts()
    {
        return self::find()->asArray()->all();
    }

    /**
     * @return ContactQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new ContactQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactAddress()
    {
        return $this->hasMany(ContactAdress::className(), ['contact_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactPhone()
    {
        return $this->hasMany(ContactPhone::className(), ['contact_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactEmail()
    {
        return $this->hasMany(ContactEmail::className(), ['contact_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getListForSearch()
    {
        $list =  Contact::find()->all();
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
