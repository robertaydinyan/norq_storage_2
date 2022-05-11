<?php

namespace app\modules\warehouse\models;

use app\models\User;
use app\modules\crm\models\Contact;
use app\modules\crm\models\ContactAdress;
use app\modules\crm\models\ContactCompany;
use app\modules\crm\models\CrmComments;
use app\modules\fastnet\models\BaseStation;
use kartik\datetime\DateTimePicker;
use app\modules\warehouse\models\Product;
use Yii;

/**
 * This is the model class for table "s_warehouse".
 *
 * @property int $id
 * @property int $type
 * @property int|null $responsible_id
 * @property string $created_at
 * @property string $name
 * @property string|null $updated_at
 * @property int|null $crm_company_id
 * @property int|null $group_id
 * @property int|null $crm_contact_id
 * @property string|null $deal_number
 * @property int|null $contact_address_id
 */
class Warehouse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_warehouse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'created_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['type','responsible_id', 'crm_company_id','group_id', 'crm_contact_id', 'contact_address_id', 'isDeleted'], 'integer'],
            [[ 'name', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => Yii::t('app', 'Warehouse type'),
            'name' => Yii::t('app', 'Name'),
            'responsible_id' => Yii::t('app', 'storekeeper'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'crm_company_id' => 'Crm Company ID',
            'crm_contact_id' => 'Crm Contact ID',
            'contact_address_id' => 'contact_address_id',
            'group_id' => Yii::t('app', 'group'),
            'address' => Yii::t('app', 'address'),
            'isDeleted' => 'isDeleted'
//            'storekeeper' => 'storekeeper'
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabelsAll()
    {
        return [
            'id' => 'ID',
            'type' => 'Warehouse type',
            'name' => 'Name',
            'responsible_id' => 'storekeeper',
//            'created_at' => 'Created',
//            'updated_at' => 'Updated at',
//            'group_id' => 'group',
//            'address' => 'address',
//            'products' => 'goods',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() {
        return $this->hasMany(Product::className(), ['warehouse_id' => 'id']);
    }
    public function getProviderWarehouseShippings() {
        return $this->hasMany(Shipping::className(), ['warehouse_id' => 'id']);
    }
    public function getSupplierWarehouseShippings() {
        return $this->hasMany(Shipping::className(), ['warehouse_id' => 'id']);
    }
    public function getContactAddress() {
        return $this->hasOne(ContactAdress::className(), ['id' => 'contact_address_id']);
    }
    public function getType($id) {
        return WarehouseTypes::findOne($id);
    }

    public function getCountByRegion($type,$id) {
        if($id) {
            return Yii::$app->db->createCommand("SELECT count(s_warehouse.id) as count_ FROM s_warehouse 
                                                  LEFT JOIN contact_adress  ON s_warehouse.contact_address_id = contact_adress.id 
                                                  WHERE contact_adress.region_id  = $id AND s_warehouse.type = $type")->queryOne()['count_'];
        } else {
            return [];
        }
    }
    public function getCountByCommunity($type,$id) {
        if($id) {
            return Yii::$app->db->createCommand("SELECT count(s_warehouse.id) as count_ FROM s_warehouse 
                                                  LEFT JOIN contact_adress  ON s_warehouse.contact_address_id = contact_adress.id 
                                                  WHERE contact_adress.community_id  = $id AND s_warehouse.type = $type")->queryOne()['count_'];
        } else {
            return [];
        }
    }
    public function getByRegionCommunities($id) {
        if($id) {
            return Yii::$app->db->createCommand("SELECT f_community.* FROM f_community  
                                                  LEFT JOIN cities  ON cities.id = f_community.city_id 
                                                  LEFT JOIN regions  ON regions.id = cities.region_id 
                                                  WHERE regions.id  = $id")->queryAll();
        } else {
            return [];
        }
    }
    public function getProductsCount() {
         return Product::find()->where(['warehouse_id'=>$this->id,'status'=>1])->count();
    }
    public function getWhUser() {
        return $this->hasOne(User::className(), ['id' => 'responsible_id']);
    }
    public function getContactAdress() {
        return $this->hasOne(ContactAdress::className(), ['id' => 'contact_address_id']);
    }
    public static function getContactAddressById($id){

            if(intval($id)) {
                $sql = "SELECT ca.id,countries.name as coname,regions.name as rname,cities.name as ciname,f_community.name as comname, CONCAT(ca.street,' ',ca.house) as house FROM contact_adress as ca
                LEFT JOIN countries ON countries.id = ca.country_id
                LEFT JOIN regions ON regions.id = ca.region_id
                LEFT JOIN cities ON cities.id = ca.city_id 
                LEFT JOIN f_community ON f_community.id = ca.community_id 
                WHERE ca.id = " . $id;
                $addr = Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_ASSOC);
                if ($addr) {
                    unset($addr[0]['id']);
                    return implode(', ', $addr[0]);
                }
            } else {
                return 'Ընտրված չէ';
            }

        return [];
    }
    public function getUser($id) {
        return User::findOne($id);
    }
//    public function getCrmContact() {
//        var_dump($this->crm_contact_id);
//        return $this->hasOne(Contact::className(), ['id' => 'crm_contact_id']);
//    }
//    public function getCities(){
//        return ArrayHelper::map(Product::find()->where(['in', 'id', [37, 38]])->all(), 'id', 'name');
//    }
}