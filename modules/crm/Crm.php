<?php

namespace app\modules\crm;

use app\modules\rbac\filters\AccessControl;

/**
 * crm module definition class
 */
class Crm extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\crm\controllers';

    /**
     * @return string[]
     */
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
