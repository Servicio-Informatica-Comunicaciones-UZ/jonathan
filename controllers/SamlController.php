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
                'class' => 'asasmoyo\yii2saml\actions\LoginAction'
            ],
            'acs' => [
                'class' => 'asasmoyo\yii2saml\actions\AcsAction',
                'successCallback' => [$this, 'callback'],
                'successUrl' => Url::to('@web/site/session'),
            ],
            'metadata' => [
                'class' => 'asasmoyo\yii2saml\actions\MetadataAction'
            ],
            'logout' => [
                'class' => 'asasmoyo\yii2saml\actions\LogoutAction',
                'returnTo' => Url::to(['site/index']),
            ],
            'sls' => [
                'class' => 'asasmoyo\yii2saml\actions\SlsAction',
                'successUrl' => Url::to(['site/index']),
            ],
        ];
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
            $user->email = User::findEmailByNip($nip);  // Defined as UNIQUE in the database.
            $user->password_hash = $attributes['businessCategory'][0];  // Just because it is defined as NOT NULL in DB.
            $user->save();

            $profile = Profile::findOne(['user_id' => $user->id]);
            $profile->name = $attributes['cn'][0];
            $profile->save();
        }

        Yii::$app->user->login($user);

        $session = Yii::$app->session;
        $session->set('saml_attributes', $attributes);
    }
}
