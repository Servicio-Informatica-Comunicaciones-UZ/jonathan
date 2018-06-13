<?php

return [
    'jonathan' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=jonathan',
        'username' => 'jonathan',
        'password' => 'jonathan',
        'charset' => 'utf8mb4',

        // Schema cache options (for production environment)
        //'enableSchemaCache' => true,
        //'schemaCacheDuration' => 60,
        //'schemaCache' => 'cache',
    ],
    'identidades' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'oci:dbname=//172.16.17.18:1521/FOOBAR;charset=UTF8',
        'username' => 'ident',
        'password' => 'ident',
    ],
];
