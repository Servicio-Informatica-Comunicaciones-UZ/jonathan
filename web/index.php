<?php

// Define our application_env variable as provided by nginx/apache / console
if (!defined('APPLICATION_ENV')) {
    if (false != getenv('APPLICATION_ENV')) {
        define(
            'APPLICATION_ENV',
            getenv('APPLICATION_ENV')
        );
    } else {
        // TODO: check if better stop execution or set prod.
        define('APPLICATION_ENV', 'prod');
    }
}

$env = require __DIR__.'/../config/env.php';

defined('YII_DEBUG') or define('YII_DEBUG', $env['debug']);
defined('YII_ENV') or define('YII_ENV', APPLICATION_ENV);

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__.'/../config/web.php';

(new yii\web\Application($config))->run();
