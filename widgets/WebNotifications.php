<?php

namespace webzop\notifications\widgets;

use Exception;
use webzop\notifications\channels\WebChannel;
use webzop\notifications\WebNotificationsAsset;
use yii\helpers\ArrayHelper;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\View;


class WebNotifications extends \yii\base\Widget
{
    /**
     * @var string VAPID public key
     */
    protected $_vapidPubKey = null;

    /**
     * module configuration params
     */
    protected $_config = array();

    /**
     * settable HTML template for module
     * @var string
     */
    public $template = '';


    /**
     *
     * @throws Exception
     */
    public function init()
    {
        parent::init();

        $this->setDefaultConfig();


        // override defaults with config params
        $module = Yii::$app->getModule('notifications');

        /** @var WebChannel|array $webChannel */
        $webChannel = $module->channels['web'];

        // we have to use array helper because in some instances yii create the channel as a WebChannel object and others
        // as an array
        if(!empty(ArrayHelper::getValue($webChannel, 'config'))) {
            $module_config = ArrayHelper::getValue($webChannel, 'config');
            $this->_config = array_merge($this->_config, $module_config);
        }


        // set VAPID public key
        if(empty(ArrayHelper::getValue($webChannel, 'auth.VAPID.publicKey'))) {
            throw new Exception('Invalid configuration for module Notification: Missing VAPID keys. Please see the readme.txt to configure correctly your application.');
        }
        $this->_vapidPubKey = ArrayHelper::getValue($webChannel, 'auth.VAPID.publicKey');

    }


    /**
     * @return mixed
     */
    protected function getConfig() {
        return array_merge(
            $this->_config,
            array(
                'vapid_pub_key' => $this->_vapidPubKey
            )
        );
    }


    /**
     * setup default configuration
     */
    public function setDefaultConfig() {
        $this->_config = array(
            'serviceWorkerFilepath' => '/service-worker.js',
            'serviceWorkerScope' => './',
            'serviceWorkerUrl' => Url::to(['/notifications/web-push-notification/service-worker']),
            'subscribeUrl' => Url::to(['/notifications/web-push-notification/subscribe']),
            'unsubscribeUrl' => Url::to(['/notifications/web-push-notification/unsubscribe']),
            'subscribeLabel' => 'Subscribe',
            'unsubscribeLabel' => 'Unsubscribe',
        );
    }


    /**
     * @inheritdoc
     */
    public function run()
    {
        // override defaults with config params
        $module = Yii::$app->getModule('notifications');

        if(ArrayHelper::getValue($module->channels['web'], 'enable')) {
            echo $this->renderSubscribeButton();
            $this->registerAssets();
        }
    }


    /**
     * @inheritdoc
     */
    protected function renderSubscribeButton()
    {

        if($this->template === false) {
            return '';
        }
        if($this->template) {
            return $this->template;
        }

        $html = Html::beginTag('p');
        $html .= Html::beginTag('button', ['id' => 'js-web-push-subscribe-button', 'disabled' => 'disabled']);
        $html .= "Subscribe";
        $html .= Html::endTag('button');
        $html .= Html::endTag('p');

        return $html;
    }


    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        WebNotificationsAsset::register($view);

        $js = 'WebNotifications(' . Json::encode($this->getConfig()) . ');';
        $view->registerJs($js, View::POS_END);
    }

}
