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
        'class' => 'apaoww\oci8\Oci8DbConnection',  // Requires apaoww/yii2-oci8
        'dsn' => 'oci8:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=oraculo.unizar.es)(PORT=1521))(CONNECT_DATA=(SID=FOOBAR)));charset=WE8ISO8859P1;',
        'username' => 'ident',
        'password' => 'ident',
    ],
];
