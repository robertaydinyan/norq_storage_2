<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$lang = preg_replace('/[^A-Za-z0-9\-]/', '', $_GET['lang']) ?: 'en-US';
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => $lang,
//    function ($event) {
//        return ;//;
//    },
    'sourceLanguage' => 'en-US',
    'defaultRoute' => '/fastnet/tariff',
    'timezone' => 'Asia/Yerevan',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@billing' => '@app/modules/billing',
        '@crm' => '@app/modules/crm',
        '@fastnet' => '@app/modules/fastnet',
        '@rbac' => '@app/modules/rbac',
        '@widgets' => '@app/widgets',
        '@warehouse' => '@app/modules/warehouse',
    ],
    'modules' => [
        'rbac' => [
            'class' => 'app\modules\rbac\Module',
        ],
        'billing' => [
            'class' => 'app\modules\billing\Billing',
        ],
        'crm' => [
            'class' => 'app\modules\crm\Crm',
        ],
        'task' => [
            'class' => 'app\modules\task\Module',
        ],
        'hr' => [
            'class' => 'app\modules\hr\Hr',
        ],
        'fastnet' => [
            'class' => 'app\modules\fastnet\Fastnet',
        ],
        'warehouse' => [
            'class' => 'app\modules\warehouse\Module',
        ],
        'dynagrid' => [
            'class' => '\kartik\dynagrid\Module',
            'i18n' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@app/messages',
                'forceTranslation' => true
            ]
            // other settings (refer documentation)
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
            // other module settings
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'MT8tdkWgRM9lIeVXcjYvxQfNIjeMOum8',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US',
                    'on missingTranslation' => ['app\components\TranslationEventHandler', 'handleMissingTranslation'],
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'encryption' => 'tls',
                'host' => 'smtp.gmail.com',
                'port' => '587',
                'username' => 'artmins96@gmail.com',
                'password' => '95123578460min',
                'streamOptions' => [
                    'ssl' => [
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ]
                ]
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'languages' =>  ['hy'],
            'enableDefaultLanguageUrlCode' => false,
            'enableLanguageDetection' => false,
            'enableLanguagePersistence' => false,
            'showScriptName' => false,
            'rules' => require(__DIR__ . '/router.php'),
        ],
        'metadata' => [
            'class' => 'app\components\Metadata',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => [
                'admin', 'manager', 'operator', 'terminal'
            ]
            // uncomment if you want to cache RBAC items hierarchy
            // 'cache' => 'cache',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;