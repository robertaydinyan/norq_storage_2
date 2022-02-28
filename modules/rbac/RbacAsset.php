<?php

namespace app\modules\rbac;

use yii\web\AssetBundle;

/**
 * Class RbacAsset
 * @package app\modules\rbac
 */
class RbacAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@rbac/assets';

    /**
     * @var array
     */
    public $js = [
        'js/rbac.js',
    ];

    public $css = [
        'css/rbac.css',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
    ];

    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
}
