<?php

return [
    'class' => 'yii\swiftmailer\Mailer',
    // send all mails to a file by default. You have to set
    // 'useFileTransport' to false and configure a transport
    // for the mailer to send real emails.
    'useFileTransport' => true,
    // NOTE: Configure transport as needed.
    // See http://swiftmailer.org/docs/sending.html
    /*
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'localhost',
        'username' => 'username',
        'password' => 'password',
        'port' => '587',
        'encryption' => 'tls',
    ],
    */
];
