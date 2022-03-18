<?php

namespace app\modules\warehouse;

use app\components\Url;
use app\modules\rbac\filters\AccessControl;
use app\modules\warehouse\models\UserHistory;
use Yii;

/**
 * warehouse module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\warehouse\controllers';

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
