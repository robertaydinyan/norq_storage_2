<?php

namespace app\modules\crm\models;

use app\modules\billing\models\Cities;
use app\modules\billing\models\Community;
use app\modules\billing\models\Countries;
use app\modules\billing\models\Regions;
use app\modules\fastnet\models\Streets;
use Yii;

/**
 * This is the model class for table "contact_adress".
 *
 * @property int $id
 * @property int|null $contact_id
 * @property int|null $company_id
 * @property int|null $country_id
 * @property int|null $region_id
 * @property int|null $city_id
 * @property int|null $community_id
 * @property int|null $street
 * @property string|null $house
 * @property string|null $housing
 * @property string|null $apartment
 */
class ContactAdress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_adress';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contact_id', 'company_id', 'country_id', 'region_id', 'city_id', 'community_id'], 'integer'],
            [['house', 'housing', 'apartment'], 'string', 'max' => 255],
            [['street'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'contact_id' => Yii::t('app', 'Contact ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'country_id' => Yii::t('app', 'Country'),
            'region_id' => Yii::t('app', 'Region'),
            'city_id' => Yii::t('app', 'District'),
            'community_id' => Yii::t('app', 'Community'),
            'street' => Yii::t('app', 'Street'),
            'house' => Yii::t('app', 'House'),
            'housing' => Yii::t('app', 'Building'),
            'apartment' => Yii::t('app', 'Apartment'),
        ];
    }
    public static function getContactAddressToString($type, $id){
        if (!is_null($id)) {
            if(intval($type == 2)){
                $where = 'WHERE ca.company_id = '.$id;
            } else {
                $where = 'WHERE ca.contact_id = '.$id;
            }
        } else {
            $where = null;
        }

        $sql = "SELECT ca.id,countries.name as coname,regions.name as rname,cities.name as ciname, CONCAT(ca.street,' ',ca.house) as house FROM contact_adress as ca
                LEFT JOIN countries ON countries.id = ca.country_id
                LEFT JOIN regions ON regions.id = ca.region_id
                LEFT JOIN cities ON cities.id = ca.city_id 
                $where";
        var_dump($sql);
        $tar = Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_ASSOC);
        $addressList = [];
        foreach ($tar as $address => $addr){
            $id = $addr['id'];
            unset($addr['id']);
            $addressList[$id] = implode(', ',$addr);
        }
        return $addressList;

    }
    public static function getContactAddressById($id){
        $deal_addresses = DealAddress::find()->where(['deal_id'=>$id])->all();
        $address_list = [];
        $return_data = [];
        if(!empty($deal_addresses)) {
            foreach ($deal_addresses as $deal_address => $value) {
                if(intval($value->address_id)) {
                    $sql = "SELECT ca.id,countries.name as coname,regions.name as rname,cities.name as ciname, CONCAT(ca.street,' ',ca.house) as house FROM contact_adress as ca
                    LEFT JOIN countries ON countries.id = ca.country_id
                    LEFT JOIN regions ON regions.id = ca.region_id
                    LEFT JOIN cities ON cities.id = ca.city_id 
                    WHERE ca.id = " . $value->address_id;
                    $addr = Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_ASSOC);
                    if ($addr) {
                        $id = $addr[0]['id'];
                        unset($addr[0]['id']);
                        $address_list[$id] = implode(', ', $addr[0]);
                        $return_data['values'][] = $id;
                    }
                }
            }
            if(!empty($address_list)){
                $return_data['addresses'] = $address_list;
                return $return_data;
            }
        }
        return [];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry(){
        return $this->hasOne(Countries::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity(){
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion(){
        return $this->hasOne(Regions::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommunity(){
        return $this->hasOne(Community::className(), ['id' => 'community_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFastStreet(){
        return $this->hasOne(Streets::className(), ['id' => 'street']);
    }
    public function getContact(){
        return $this->hasOne(Contact::className(), ['id' => 'contact_id']);
    }
}
