<?php

namespace app\models\query;

use app\modules\billing\models\Cities;
use app\modules\billing\models\Community;
use app\modules\billing\models\Countries;
use app\modules\billing\models\Internet;
use app\modules\billing\models\IpAddresses;
use app\modules\billing\models\Regions;
use app\modules\billing\models\TvChannel;
use app\modules\billing\models\TvPacketChannel;
use app\modules\crm\models\Company;
use app\modules\crm\models\Contact;
use app\modules\fastnet\models\Deal;
use app\modules\fastnet\models\Streets;
use app\modules\warehouse\models\NomenclatureProduct;
use app\modules\warehouse\models\Product;
use yii\db\ActiveQuery;

class BaseQuery extends ActiveQuery
{

    /**
     * @param null $internet
     * @param null $tv
     * @param null $ip
     * @return float|int
     */
    public static function calculateTariffSum($internet = null, $tv = null, $ip = null)
    {
        $sum = [];
        $channel = [];

        if (!empty($internet)) {
            $sum[] = Internet::find()->where(['id' => $internet])->sum('price');
        }

        if (!empty($tv)) {
            $packet = TvPacketChannel::find()->where(['packet_id' => $tv])->all();
            foreach ($packet as $item) {
                $channel[] = TvChannel::find()->where(['id' => $item->channel_id])->sum('amount');
            }
        }

        if (!empty($ip)) {
            $sum[] = IpAddresses::find()->sum('price');
        }

        if (!empty($channel)) {
            $totalPrice = array_sum($sum) + array_sum($channel);
        } else {
            $totalPrice = array_sum($sum);
        }

        return $totalPrice;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getCountriesList()
    {
        return Countries::find()->all();
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getRegionsList()
    {
        return Regions::find()->all();
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getCitiesList()
    {
        return Cities::find()->all();
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getRegionByCountry($id)
    {
        if (!empty($id)) {
            return Regions::find()->where(['country_id' => $id])->all();
        }
    }
    public static function getNProductByWarehouse($id)
    {
        if (!empty($id)) {
            return Product::find()->select(
                's_nomenclature_product.id, 
                s_nomenclature_product.name'
            )
                ->where(['warehouse_id' => $id])
                ->joinWith(['nProduct'])
                ->asArray()
                ->all();
        }
    }
    public static function getProductByWarehouse($nProductId, $warehouseId)
    {
        $productType = NomenclatureProduct::findOne($nProductId);
        if ($productType->individual  == 'true'){
            return Product::find()->select('id, price, mac_address')
                ->where(['warehouse_id' => $warehouseId])
                ->andWhere(['nomenclature_product_id' => $nProductId])
                ->orderBy(['price' => SORT_DESC])
                ->asArray()
                ->all();
        } else {
            return Product::find()->select('s_product.id, s_product.count, s_qty_type.type')
                ->where(['warehouse_id' => $warehouseId])
                ->andWhere(['nomenclature_product_id' => $nProductId])
                ->joinWith(['nProduct'])
                ->joinWith(['nProduct.qtyType'])
                ->asArray()
                ->all();
        }


    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */

    public static function getCitiesByRegion($id)
    {
        if (!empty($id)) {
            return Cities::find()->where(['region_id' => $id])->all();
        }
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getStreetsByCity($id)
    {
        if (!empty($id)) {
            return Streets::find()->where(['city_id' => $id])->all();
        }
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getStreetsByCommunity($id)
    {
        if (!empty($id)) {
            return Streets::find()->where(['community_id' => $id])->all();
        }
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getCommunitiesByCity($id)
    {
        if (!empty($id)) {
            return Community::find()->where(['city_id' => $id])->all();
        }
    }


    /**
     * @param $id
     * @return array
     */
    public static function renderRegions($id)
    {
        if (!empty($id)) {
            $options = [];

            $optionsList = self::getRegionByCountry($id);

            if (!empty($optionsList)) {
                foreach ($optionsList as $option) {
                    $options[] = ['id' => $option['id'], 'text' => $option['name']];
                }
            }

            return $options;
        }
    }
    public static function renderNProduct($id)
    {
        if (!empty($id)) {
            $options = [];

            $optionsList = self::getNProductByWarehouse($id);

            if (!empty($optionsList)) {
                foreach ($optionsList as $option) {
                    $options[] = ['id' => $option['id'], 'text' => $option['name']];
                }
            }

            return $options;
        }
    }
    public static function renderProductMacAddres($nProductId, $warehouseId)
    {
        if (!empty($nProductId) && !empty($warehouseId)) {
            $options = [];

            $optionsList = self::getproductByWarehouse($nProductId, $warehouseId);

            if (!empty($optionsList)) {
                $count = 0;
                foreach ($optionsList as $option) {
                    if (array_key_exists('mac_address', $option)) {
                        $text =  $option['mac_address'];
                        $options['individual'][] = ['id' => $option['id'], 'text' => $text];
                    } else {

                        $count+=$option['count'];
                        $text = 'պահեստում կա' . ' ' . $count . ' ' . $option['type'];
                        $options = ['id' => $nProductId, 'text' => $text];
                    }
                }
            }

            return $options;
        }
    }
    /**
     * @param $id
     * @return array
     */
    public static function renderCities($id)
    {
        if (!empty($id)) {
            $options = [['id' => 0, 'text' => \Yii::t('app', 'Выберите')]];

            $optionsList = self::getCitiesByRegion($id);

            if (!empty($optionsList)) {
                foreach ($optionsList as $option) {
                    $options[] = ['id' => $option['id'], 'text' => $option['name']];
                }
            }

            return $options;
        }
    }

    /**
     * @param $id
     * @param false $streetByCommunity
     * @return array[]
     */
    public static function renderStreets($id, $streetByCommunity = false)
    {
        if (!empty($id)) {
            $options = [['id' => 0, 'text' => \Yii::t('app', 'Выберите')]];

            $optionsList = !$streetByCommunity ? self::getStreetsByCity($id) : self::getStreetsByCommunity($id);

            if (!empty($optionsList)) {
                foreach ($optionsList as $option) {
                    $options[] = ['id' => $option['id'], 'text' => $option['name']];
                }
            }
            return $options;
        }
    }

    /**
     * @param $id
     * @return array[]
     */
    public static function renderCommunity($id)
    {
        if (!empty($id)) {
            $options = [['id' => 0, 'text' => \Yii::t('app', 'Выберите')]];

            $optionsList = self::getCommunitiesByCity($id);

            if (!empty($optionsList)) {
                foreach ($optionsList as $option) {
                    $options[] = ['id' => $option['id'], 'text' => $option['name']];
                }
            }
            return $options;
        }
    }

    /**
     * @param $id
     * @param false $baseStation
     * @return array
     */
    public static function renderDeals($id, $baseStation = false)
    {
        if (!empty($id)) {
            $result = (new \yii\db\Query())
                ->select(['f_deal.deal_number','f_deal.crm_contact_id','f_deal.crm_company_id','f_deal.id as deal_id','contact_adress.*'])
                ->from(['f_deal'])
                ->join('LEFT JOIN', 'f_deal_address','f_deal_address.deal_number = f_deal.deal_number')
                ->join('LEFT JOIN', 'contact_adress','contact_adress.id = f_deal_address.contact_address_id')
                ->where(['not in', 'f_deal.status', [Deal::CLOSED, Deal::SUSPENDED, Deal::CONTRACT_TERMINATION]]);

                if ($baseStation) {
                    $result->andWhere(['in', 'f_deal.base_station_id', $id]);
                } else {
                    $result->andWhere(['contact_adress.community_id' => intval($id)]);
                }

                $res = $result->all();

            $items = [];

            if(!empty($res)) {
                foreach ($res as $item) {
                    if($item['crm_contact_id']) {
                        $item['contact_data'] = Contact::find()->select('name, surname')->where(['id' => $item['crm_contact_id']])->asArray()->one();
                    } else {
                        $item['contact_data'] = Company::find()->select('name')->where(['id' => $item['crm_company_id']])->asArray()->one();
                    }
                    $items[] = $item;
                }
            }
            return $items;
        }
    }

}