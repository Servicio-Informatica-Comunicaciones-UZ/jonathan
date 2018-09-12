<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;
use \Da\User\Model\Profile;
use app\models\User;

class SamlController extends Controller
{
    // Remove CSRF protection
    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'login' => [
                // This action will initiate the login process with the Identity Provider specified in the config file.
                'class' => 'asasmoyo\yii2saml\actions\LoginAction'
            ],
            'acs' => [
                // Assertion Consumer Service
                // This action will process the SAML response sent by the Identity Provider after succesful login.
                // You can register a callback to do some operation like reading the attributes sent by Identity Provider
                // and create a new user from those attributes.
                'class' => 'asasmoyo\yii2saml\actions\AcsAction',
                'successCallback' => [$this, 'callback'],
                'successUrl' => Url::to('@web/propuesta/listado'),
            ],
            'metadata' => [
                // This action will show metadata of your application in XML.
                'class' => 'asasmoyo\yii2saml\actions\MetadataAction'
            ],
            'logout' => [
                // This action will initiate the SingleLogout process with the Identity Provider.
                'class' => 'asasmoyo\yii2saml\actions\LogoutAction',
                'returnTo' => Url::to(['//site/index']),
            ],
            'sls' => [
                // Single Logout Service
                // This action will process the SAML logout request/response sent by the Identity Provider.
                'class' => 'asasmoyo\yii2saml\actions\SlsAction',
                'successUrl' => Url::to(['//site/index']),
            ],
        ];  // NOTE: The acs and sls URLs should be set in the AssertionConsumerService and SingleLogoutService sections
            // of the metadata of this Service Provider in the IdP.
    }


    /**
     * @param array $attributes Attributes sent by the Identity Provider.
     */
    public function callback($attributes)
    {
        // SAML validation succeeded.  Let's login
        // Yii::info('SAML received attributes: ' . VarDumper::dumpAsString($attributes));

        $nip = $attributes['uid'][0];
        $user = User::findByUsername($nip);

        // If it is the first time the user logs in, let's add it to the database.
        if (!$user) {
            $user = new User;
            $user->username = $nip;
            $user->email = "{$nip}@unizar.es";  // Defined as UNIQUE in the DB.
            $user->password_hash = $attributes['businessCategory'][0];  // Just because it is defined as NOT NULL in DB.
            $user->save();
        }

        // email and name may change.  Let's update them.
        $identidad = User::findIdentidadByNip($nip);
        $user->email = $identidad['CORREO_PRINCIPAL'];
        $user->save();
        $profile = Profile::findOne(['user_id' => $user->id]);
        $profile->name = "{$identidad['NOMBRE']} {$identidad['APELLIDO_1']} {$identidad['APELLIDO_2']}";  // $attributes['cn'][0];
        $profile->gravatar_email = $user->email;
        // TODO: Extender el profile para guardar el colectivo, nombres y apellidos por separado, etc.
        $profile->save();

        Yii::$app->user->login($user);

        $session = Yii::$app->session;
        $session->set('saml_attributes', $attributes);
    }
}
