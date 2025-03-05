<?php

// Load application parameters and database configuration
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic', // Application ID
    'basePath' => dirname(__DIR__), // Base directory of the application
    'bootstrap' => ['log'], // Components to be loaded at the start
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // Security: Cookie validation key (change this for production)
            'cookieValidationKey' => 'VECBL0beyObq5u5pPyxsWNaH8qPPWfQF',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache', // Enables file caching
        ],
        'user' => [
            'identityClass' => 'app\models\User', // User authentication class
            'enableAutoLogin' => true, // Enables "remember me" functionality
        ],
        'errorHandler' => [
            'errorAction' => 'site/error', // Custom error handling route
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true, // Set to false for real email sending
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
        'db' => $db, // Database connection (PostgreSQL in our case)

        'urlManager' => [
            'enablePrettyUrl' => true, // Enables SEO-friendly URLs
            'showScriptName' => false, // Hides index.php in URLs
            'rules' => [
                // Define custom URL rules here
            ],
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
        'resume' => [
            'class' => 'app\modules\resume\Module',
        ],
        'payment' => [
            'class' => 'app\modules\payment\Module',
        ],
    ],
    'params' => $params, // Application parameters
];

if (YII_ENV_DEV) {
    // Configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        //'allowedIPs' => ['127.0.0.1', '::1'], // Restrict debug access
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        //'allowedIPs' => ['127.0.0.1', '::1'], // Restrict Gii access
    ];
}

return $config;