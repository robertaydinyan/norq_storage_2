<?php
error_reporting(0);
ini_set('display_errors', 0);

// comment out the following two lines when deployed to production
use app\components\Debug;

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';
require __DIR__ . '/../components/routeros_api.class.php';

/**
 * Dump
 */
function varDumper() {
    array_map(function($x) { Debug::var_dump($x); }, func_get_args());
}

(new yii\web\Application($config))->run();
