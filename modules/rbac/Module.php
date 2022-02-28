<?php

namespace app\modules\rbac;

/**
 * rbac module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @var string the default route of this module. Defaults to 'default'
     */
    public $defaultRoute = 'assignment';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\rbac\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
