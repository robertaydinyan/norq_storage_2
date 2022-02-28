<?php

namespace app\modules\billing\controllers;

use app\components\GoogleTranslate\GoogleTranslate;
use app\modules\billing\models\ChannelBroadcastLanguage;
use app\modules\billing\models\ChannelBroadcastLanguageSearch;
use app\modules\billing\models\ChannelCategory;
use app\modules\billing\models\ChannelCategorySearch;
use app\modules\billing\models\ChannelQuality;
use app\modules\billing\models\ChannelQualitySearch;
use app\modules\billing\models\Cities;
use app\modules\billing\models\Community;
use app\modules\billing\models\Countries;
use app\modules\billing\models\DisruptionOptionsSearch;
use app\modules\billing\models\InternetSearch;
use app\modules\billing\models\IpAddresses;
use app\modules\billing\models\Regions;
use app\modules\billing\models\CommunitySearch;
use app\modules\billing\models\TvChannel;
use app\modules\billing\models\TvChannelSearch;
use app\modules\billing\models\TvPacket;
use app\modules\billing\models\TvPacketSearch;
use app\modules\billing\models\Units;
use app\modules\billing\models\UnitsSearch;
use app\modules\billing\models\VacationOptionsSearch;
use app\modules\crm\models\CompanyScope;
use app\modules\crm\models\CompanyScopeSearch;
use app\modules\crm\models\CompanyType;
use app\modules\crm\models\CompanyTypeSearch;
use app\modules\crm\models\CrmStatus;
use app\modules\crm\models\CrmStatusSearch;
use app\modules\crm\models\Currency;
use app\modules\crm\models\CurrencySearch;
use app\modules\crm\models\DealType;
use app\modules\crm\models\DealTypeSearch;
use app\modules\billing\models\AntennaIp;
use app\modules\task\models\TaskOption;
use app\modules\task\models\TaskOptionSearch;
use app\modules\task\models\TaskPrioritySearch;
use Yii;

class ConfigsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $ipAddresses = IpAddresses::filterIpAddresses();
        return $this->render('index', ['ipAddresses' => $ipAddresses]);
    }

    /**
     * @return string
     */
    public function actionAntennaIp()
    {
        return $this->render('antenna-ip', ['ipAddresses' => AntennaIp::getList()]);
    }

    /**
     * @return string
     */
    public function actionVacationOptions()
    {
        $searchModel = new VacationOptionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('vacation-options', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionDisruptionOptions()
    {
        $searchModel = new DisruptionOptionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('disruption-options', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionTaskOptions()
    {
        $searchModel = new TaskOptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('task-options', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionTaskPriority()
    {
        $searchModel = new TaskPrioritySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('task-priority', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionConfigChannelQuality()
    {

        $searchModel = new ChannelQualitySearch();
        $dataProvider = $searchModel->search_new();

        $channelQuality = ChannelQuality::getChannelQuality();
        return $this->render('config-channel-quality',[
            'channelQuality' =>$channelQuality,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionConfigChannelCategory()
    {

        $searchModel = new ChannelCategorySearch();
        $dataProvider = $searchModel->search_new();

        $channelCategory = ChannelCategory::getChannelCategory();
        return $this->render('config-channel-category',[
            'channelCategory' =>$channelCategory,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionConfigChannelBroadcastLanguage()
    {

        $searchModel = new ChannelBroadcastLanguageSearch();
        $dataProvider = $searchModel->search_new();

        $channelBroadcastLanguage = ChannelBroadcastLanguage::getChannelBroadcastLanguage();
        return $this->render('config-channel-broadcast-language',[
            'channelBroadcastLanguage' =>$channelBroadcastLanguage,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRemoveIp()
    {
        $id = intval(Yii::$app->request->post()['id']);
        return IpAddresses::findOne($id)->delete();
    }

    public function actionRemoveAntennaIp()
    {
        $id = intval(Yii::$app->request->post()['id']);
        return AntennaIp::findOne($id)->delete();
    }

    public function actionConfigTvChannel()
    {

        $searchModel = new TvChannelSearch();
        $dataProvider = $searchModel->search_new();

        $channels = IpAddresses::getTvChannels();
        return $this->render('config-tv-channel',[
            'channels' =>$channels,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionConfigTvPacket()
    {

        $searchModel = new TvPacketSearch();
        $dataProvider = $searchModel->search_new();

        $packets = IpAddresses::getTvPackets();
        return $this->render('config-tv-packet',[
            'packets'=>$packets,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionConfigInternet()
    {

        $searchModel = new InternetSearch();
        $dataProvider = $searchModel->search_new();

        $internet = IpAddresses::getInternet();
        return $this->render('config-internet',[
            'internet' => $internet,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
    public function actionConfigDealType()
    {

        $searchModel = new DealTypeSearch();
        $dataProvider = $searchModel->search_new();

        $dealType = DealType::getDealType();
        return $this->render('config-dela-type',[
            'dealType' => $dealType,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
    public function actionConfigCrmStatus()
    {

        $searchModel = new CrmStatusSearch();
        $dataProvider = $searchModel->search_new();

        $status = CrmStatus::getCrmStatus();
        return $this->render('config-crm-status',[
            'status' => $status,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
    public function actionConfigCompanyType()
    {

        $searchModel = new CompanyTypeSearch();
        $dataProvider = $searchModel->search_new();

        $companyType = CompanyType::getCompanyType();
        return $this->render('config-company-type',[
            'companyType' => $companyType,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionConfigCurrency()
    {

        $searchModel = new CurrencySearch();
        $dataProvider = $searchModel->search_new();

        $currency = Currency::getCurrency();
        return $this->render('config-currency',[
            'currency' => $currency,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionConfigCompanyScope()
    {

        $searchModel = new CompanyScopeSearch();
        $dataProvider = $searchModel->search_new();

        $companyScope = CompanyScope::getCompanyScope();
        return $this->render('config-company-scope',[
            'companyScope' => $companyScope,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionConfigUnits()
    {

        $searchModel = new UnitsSearch();
        $dataProvider = $searchModel->search_new();

        $units = Units::getUnits();
        return $this->render('config-units',[
            'units' => $units,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
    /**
     * @return string
     */
    public function actionCountries(){

        $post = Yii::$app->request->post();

        if ($post) {

            if (!$post['country']) {
                Yii::$app->session->setFlash('country_error', 'Название страны пусто');
                return $this->redirect(['countries']);
            }

            $country = Countries::find()->where(['name' => $post['country']])->one();
            $country_name = Regions::find()->where(['name' => $post['region']])->one();
            $city_name = Cities::find()->where(['name' => $post['title']])->andWhere(['city_type' =>  $post['city_type_title']])->one();

            $translate = new GoogleTranslate();

            if (!$country) {
                $countries = new Countries();
                $countries->name = $translate->setSource('ru')->setTarget('hy')->translate($post['country']);
                $countries->code = $post['country_code'];
                $countries->save();
            }

            $country = Countries::find()->where(['name' => $post['country']])->one();

            if (!$country_name) {

                if(!empty($post['region'])) {
                    $regions = new Regions();
                    $regions->name = str_replace(':', '', $translate->setSource('ru')->setTarget('hy')->translate($post['region']));
                    $regions->country_id = empty($country->id) ? 1 : $country->id;
                    $regions->save();
                } else {
                    $regions = new Regions();
                    $regions->name = $translate->setSource('ru')->setTarget('hy')->translate($post['title']);
                    $regions->country_id = $country->id;
                    $regions->save();
                }
            }

            if (!$city_name) {
                $cities = new Cities();
                $cities->name = $translate->setSource('ru')->setTarget('hy')->translate($post['title']);
                $cities->city_type = $translate->setSource('ru')->setTarget('hy')->translate($post['city_type_title']);
                $cities->city_type_id = $post['city_type_id'];
                $cities->lat = $post['lat'];
                $cities->lng = $post['lng'];
                if (!$country_name) {
                    $cities->region_id = $regions->id;
                } else {
                    $cities->region_id = $country_name->id;
                }
                $cities->save();
            }

            return $this->redirect(['countries-list']);
        }

        return $this->render('countries');
    }

    public function actionCountriesList(){
        $res = Cities::getCitiesTable();


        return $this->render('countries-list',[
            'res' => $res
        ]);
    }





}
