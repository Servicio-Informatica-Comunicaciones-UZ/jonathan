<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'jonathan',  // Unique ID that differentiates an application from others.
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'bootstrap' => [
        'log',
        'queue',  // The component registers its own console commands
    ],
    'components' => [
        'authManager' => [
            'class' => 'Da\User\Component\AuthDbManagerComponent',
            // 'class' => 'yii\rbac\DbManager',
            // 'defaultRoles' => [],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => $db,
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ], [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['usuarios'],
                    'logFile' => '@runtime/logs/usuarios.log',
                ]
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'queue' => [
            // 'as log' => \yii\queue\LogBehavior::class,
            'channel' => 'default',  // Queue channel key
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db',  // DB connection component or its config.
            'mutex' => \yii\mutex\MysqlMutex::class,  // Mutex used to sync queries
            'tableName' => '{{%queue}}',  // Table name
            'ttr' => 5 * 60,  // Max time for job execution
            'attempts' => 3,  // Max number of attempts
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'VNvd9TIBGgiFei-Eu4Yf6OWNX_nYJaQj',
        ],
        'saml' => [
            'class' => 'asasmoyo\yii2saml\Saml',
            'configFileName' => '@app/config/env/' . APPLICATION_ENV . '/saml.php',  // OneLogin_Saml config file (Optional)
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        /*
        'user' => [  // En la sección modules está la clase user de 2amigos
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        */
    ],
    'language' => 'es',  // Language in which the application should display content to end users
    'modules' => [
        'user' => [
            'class' => Da\User\Module::class,
            'administrators' => ['superadmin'],
            'enableRegistration' => true,
            'administratorPermissionName' => 'SuperAdmin',
            'classMap' => [
                //'LoginForm' => 'app\models\LoginForm'
                'User' => app\models\User::class,  // Para poder extender la clase Da\User\Model\User
            ],

            // ...other configs from here: [Configuration Options](installation/configuration-options.md), e.g.
            // 'generatePasswords' => true,
            // 'switchIdentitySessionKey' => 'myown_usuario_admin_user_key',
        ],
    ],
    'name' => 'Propuestas de másteres de referencia',  // Application name that may be displayed to end users
    'params' => $params,
    'timeZone' => 'Europe/Madrid',  // Default time zone of the PHP runtime
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'panels' => [
            'queue' => \yii\queue\debug\Panel::class,
        ],
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
