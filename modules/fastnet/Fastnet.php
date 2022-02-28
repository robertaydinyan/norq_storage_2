<?php

namespace app\modules\fastnet;

use app\modules\rbac\filters\AccessControl;

/**
 * fastnet module definition class
 */
class Fastnet extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\fastnet\controllers';

    public function behaviors()
    {
        return [
            AccessControl::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
