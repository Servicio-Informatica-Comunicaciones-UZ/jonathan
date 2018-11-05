Jonathan
========

Jonathan es una aplicación web para proponer y valorar nuevas titulaciones,
desarrollada en PHP con el framework [Yii 2](http://www.yiiframework.com/).


Requisitos
----------

* PHP 7, con la extensión PHP Data Objects (PDO)
* Los módulos curl, GD, intl, JSON, LDAP, mbstring y XML para PHP
* El módulo mcrypt de PHP, requerido por asasmoyo/yii2-saml, que en PHP 7.2+ es necesario instalar con `pecl` y habilitar con `phpenmod`.
  ```shell
  sudo apt install gcc make autoconf libc-dev pkg-config php-dev libmcrypt-dev
  sudo pecl install mcrypt-1.0.1
  ```
  Habilitarlo añadiendo `extension=mcrypt.so` al final de `etc/php/7.2/{cli, apache, fpm}/php.ini`.
  Reiniciar el servicio con `systemctl restart php7.2-fpm` o la orden correspondiente.
  Véase [How to install mcrypt in php7.2](https://lukasmestan.com/install-mcrypt-extension-in-php7-2/)
* Un SGBD aceptado por PDO (vg PostgreSQL o MySQL), y el módulo para PHP correspondiente
* [Oracle Instant Client](http://www.oracle.com/technetwork/database/features/instant-client/index-097480.html)
  (basic y devel).
  Instalar con `pecl` el paquete [`oci8`](https://pecl.php.net/package/oci8).
  En la sección _Dynamic Extensions_ de la configuración CLI de PHP añadir la línea `extension=oci8`.
* Un servidor web que interprete PHP (vg Apache)
* La última versión de [Composer](https://getcomposer.org/download/)
* [Node.js](https://nodejs.org/es/download/package-manager/#distribuciones-de-linux-basadas-en-debian-y-ubuntu) 6.4.0+
  para utilizar [Puppeteer](https://developers.google.com/web/tools/puppeteer/)
  que a su vez usará Google Chrome / Chromium en modo _headless_ para generar los PDF.
* Tipos de letra [Gentium](https://software.sil.org/gentium/) y [EB Garamond](http://www.georgduffner.at/ebgaramond/)
  (paquetes Debian fonts-sil-gentium y fonts-ebgaramond).


Instalación
------------

* Clonar el repositorio y configurar el servidor web para que sirva el directorio
  `web`.  Puede ser conveniente usar FPM.
* Instalar las dependencias:
  ```
  $ cd jonathan
  $ composer install
  ```
  En `vendor` puede ser necesario crear un enlace simbólico `bower` -> `bower-asset`.
  Comprobar que el proceso web puede leer los ficheros de `vendor/npm-asset/proxy-from-env`.
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
* Editar el fichero `config/env/<entorno>/db.php` y configurar las bases de datos.
  
  ```php
  return [
      'jonathan' => [
          'class' => 'yii\db\Connection',
          'dsn' => 'mysql:host=localhost;dbname=foobar',
          'username' => 'pericodelospalotes',
          'password' => '1234',
          'charset' => 'utf8mb4',
      ],
      'identidades' => [
          'class' => 'apaoww\oci8\Oci8DbConnection',  // Requires apaoww/yii2-oci8
          'dsn' => 'oci8:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=oraculo.unizar.es)(PORT=1521))(CONNECT_DATA=(SID=DELFOS)));charset=WE8ISO8859P1;',
          'username' => 'dodona',
          'password' => 'PopolWuj',
          'attributes' => [],
      ]
  ],
  ```
* Editar el fichero `config/env/<entorno>/mailer.php` y configurar el servidor SMTP.
* Editar el fichero `config/env/<entorno>/params.php` y configurar el servidor LDAP, etc.
* Crear el fichero `config/env/<entorno>/saml.php` y editarlo para introducir los
  datos de nuestro *Identity Provider*.  Por su parte el IdP deberá tener los datos de
  este *Service Provider*.
