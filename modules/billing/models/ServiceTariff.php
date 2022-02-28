<?php

namespace app\modules\billing\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "service_tariff".
 *
 * @property int $service_id
 * @property int $tariff_id
 * @property int|null $actual_price_type
 * @property float|null $actual_price
 */
class ServiceTariff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_tariff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'tariff_id'], 'required'],
            [['service_id', 'tariff_id', 'actual_price_type'], 'integer'],
            [['actual_price'], 'number'],
            [['service_id', 'tariff_id'], 'unique', 'targetAttribute' => ['service_id', 'tariff_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'service_id' => Yii::t('app', 'Service ID'),
            'tariff_id' => Yii::t('app', 'Tariff ID'),
            'actual_price_type' => Yii::t('app', 'Actual Price Type'),
            'actual_price' => Yii::t('app', 'Actual Price'),
        ];
    }

    public function getTariff(){

        return $this->hasOne(Tariff::className(), ['id' => 'tariff_id']);
    }

    public static function getServiceTariff($service_id){

        $sql = "SELECT tar.id, tar.name FROM service_tariff as st
                LEFT JOIN tariff as tar ON tar.id = st.tariff_id
                WHERE st.service_id = '$service_id'";

        $tar = Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_OBJ);

        return ArrayHelper::map($tar, 'id', 'name');

    }
    public static function getServiceTariffWithPrice($service_id){

        $sql = "SELECT tar.id, tar.name,st.total_price as price FROM service_tariff as st
                LEFT JOIN tariff as tar ON tar.id = st.tariff_id
                WHERE st.service_id = '$service_id'";

        $tar = Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_OBJ);

        return $tar;

    }

}
