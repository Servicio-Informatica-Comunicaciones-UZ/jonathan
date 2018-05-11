<?php

$db = require __DIR__ . '/db.php';
$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'basic-console',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
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
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
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
    ],
    'controllerMap' => [
        'batch' => [
            'class' => 'schmunk42\giiant\commands\BatchController',
            'overwrite' => true,
            'modelNamespace' => 'app\\modules\\crud\\models',
            'modelQueryNamespace' => 'app\\modules\\crud\\models\\query',
            'crudControllerNamespace' => 'app\\modules\\crud\\controllers',
            'crudSearchModelNamespace' => 'app\\modules\\crud\\models\\search',
            'crudViewPath' => '@app/modules/crud/views',
            'crudPathPrefix' => '/crud/',
            'crudTidyOutput' => true,
            'crudAccessFilter' => true,
            'crudProviders' => [
                'schmunk42\\giiant\\generators\\crud\\providers\\optsProvider',
            ],
            'tablePrefix' => 'app_',
            /*'tables' => [
                'app_profile',
            ]*/
        ],
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationPath' => [
                '@app/migrations',
                '@yii/rbac/migrations',  // Just in case you forgot to run it on console (see next note)
            ],
            'migrationNamespaces' => [
                'Da\User\Migration',
            ],
        ],
    ],
    'controllerNamespace' => 'app\commands',
    'modules' => [],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
