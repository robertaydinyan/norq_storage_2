<?php
/*
author :: Pitt Phunsanit
website :: http://plusmagi.com
change language by get language=EN, language=TH,...
or select on this widget
*/

namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\Widget;
use yii\bootstrap4\ButtonDropdown;
use yii\helpers\Url;
use yii\web\Cookie;

class LanguageDropdown extends Widget
{

    public $languages = [
        'en' => 'English',
        'ru' => 'Русский',
        'hy' => 'Հայերեն',
    ];

    public function init()
    {
        if(php_sapi_name() === 'cli')
        {
            return true;
        }

        parent::init();

        $cookies = Yii::$app->response->cookies;
        $languageNew = Yii::$app->request->get('language');
        if($languageNew)
        {
            if(isset($this->languages[$languageNew]))
            {
                Yii::$app->language = $languageNew;
                $cookies->add(new \yii\web\Cookie([
                    'name' => 'language',
                    'value' => $languageNew
                ]));
            }
        }
        elseif($cookies->has('language'))
        {
            Yii::$app->language = $cookies->getValue('language');
        }

    }

    public function run(){
        $languages = $this->languages;
        $current = $languages[Yii::$app->language];
        unset($languages[Yii::$app->language]);

        $items = [];
        foreach($languages as $code => $language)
        {
            $temp = [];
            $temp['label'] = $language;
            $temp['url'] = Url::current(['language' => $code]);
            array_push($items, $temp);
        }

        echo ButtonDropdown::widget([
            'label' => $current,
            'options' => [
                'class' => 'mr-3',
            ],
            'dropdown' => [
                'items' => $items,
                'options' => [
                    'class' => 'dropdown-menu-right', // right dropdown
                ],
            ],

        ]);
    }

}