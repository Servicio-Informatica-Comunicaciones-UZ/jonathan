Jonathan
========

Jonathan es una aplicación web para proponer y valorar nuevas titulaciones,
desarrollada en PHP con el framework [Yii 2](http://www.yiiframework.com/).


Requisitos
----------

* PHP 7, con la extensión PHP Data Objects (PDO)
* Los módulos curl, GD, intl, JSON, LDAP, mbstring y XML para PHP
* El módulo mcrypt de PHP, que en PHP 7.2+ es necesario instalar con `pecl` y habilitar con `phpenmod`.
  Ver [How to install mcrypt in php7.2](https://lukasmestan.com/install-mcrypt-extension-in-php7-2/)
* Un SGBD aceptado por PDO (vg PostgreSQL o MySQL), y el módulo para PHP correspondiente
* Un servidor web que interprete PHP (vg Apache)
* La última versión de [Composer](https://getcomposer.org/download/)
* Google Chrome / Chromium


Instalación
------------

* Clonar el repositorio y configurar el servidor web para que sirva el directorio
  `web`.  Puede ser conveniente usar FPM.
* Instalar las dependencias:
  ```
  $ cd jonathan
  $ composer install
  ```
  En `vendor` puede ser necesario crear un enlace simbólico `bower` -> `bower-asset`
* Conceder al proceso web (www-data en Debian) permisos de escritura sobre los directorios:
  * `runtime`
  * `web/assets`
  * `web/pdf/*`
  
  Para desarrollo concederle también permisos sobre estos directorios y sus
  subdirectorios:
  * `gii`
  * `models`
  * `views`
  * `controllers`
* Crear la base de datos
* Configurar la base de datos, LDAP, etc para el entorno en cuestión (ver más abajo).
* Ejecutar las migraciones:
  ```
  ./yii migrate
  ```


Configuración
-------------

* Establecer la clave para validación de cookies en el fichero `config/web.php` a
  una cadena aleatoria secreta.
  
  ```php
  'request' => [
      // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
      'cookieValidationKey' => 'VNvd9TIBGgiFei-Eu4Yf6OWNX_nYJaQj',
  ],
  ```
* En la configuración del *virtualhost* se puede establecer el entorno (dev, prod, test):
  
  ```
  SetEnv APPLICATION_ENV prod
  ```
  También se puede establecer en el `.bashrc`:
  
  ```
  export APPLICATION_ENV="dev"
  ```
* Editar el fichero `config/env/<entorno>/db.php` y configurar la base de datos.
  
  ```php
  return [
      'class' => 'yii\db\Connection',
      'dsn' => 'mysql:host=localhost;dbname=foobar',
      'username' => 'pericodelospalotes',
      'password' => '1234',
      'charset' => 'utf8mb4',
  ];
  ```
* Editar el fichero `config/env/<entorno>/mailer.php` y configurar el servidor SMTP.
* Editar el fichero `config/env/<entorno>/params.php` y configurar el servidor LDAP, etc.
* Crear el fichero `config/env/<entorno>/saml.php` y editarlo para introducir los
  datos de nuestro *Identity Provider*.  Por su parte el IdP deberá tener los datos de
  este *Service Provider*.
