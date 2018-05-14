<?php
/**
 * Modelo de la tabla User.
 *
 * @author  Enrique Matías Sánchez <quique@unizar.es>
 * @license GPL-3.0+
 */

namespace app\models;

use Yii;
use yii\web\ServerErrorHttpException;
use \Da\User\Model\User as BaseUser;

class User extends BaseUser
{
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Busca en la rama correo del LDAP la dirección correspondiente a un NIP.
     */
    public static function findEmailByNip($nip)
    {
        $ldap_host = Yii::$app->params['ldap']['host'];
        $ldap_port = Yii::$app->params['ldap']['port'];
        $base_dn = Yii::$app->params['ldap']['base_dn']; // Active Directory base DN

        // Connecting to LDAP server (data source)
        // The "@" will silence any php errors and warnings the function could raise.
        // See http://php.net/manual/en/language.operators.errorcontrol.php
        if (!$ds = @ldap_connect($ldap_host, $ldap_port)) {
            throw new ServerErrorHttpException(Yii::t('app', 'The provided LDAP parameters are syntactically wrong.'));
        }
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

        // ldap_connect() does not actually test the connection to the
        // specified LDAP server, it is just a syntactic check.
        // Let's do now an anonymous bind (requires anonymous login being enabled).
        if (!@ldap_bind($ds)) {
            throw new ServerErrorHttpException(Yii::t('app', 'Could not bind to the LDAP server.'));
        }

        // RFC specifications define many standard LDAP attributes, including
        // RFC 2256: cn (Common Name)
        // RFC 2798: mail (primary e-mail address)
        // RFC 2307: uidNumber (user's integer identification number)
        // Let's look for the email address.
        $filter = "(uidNumber=$nip)";
        $attributes = ['mail'];
        $results = @ldap_search($ds, $base_dn, $filter, $attributes);
        if (!$results) {
            throw new ServerErrorHttpException(Yii::t('app', 'Unable to search LDAP server'));
        }
        // $number_returned = ldap_count_entries($ds, $results);
        $entries = ldap_get_entries($ds, $results);
        $mail = $entries[0]['mail'][0];
        ldap_unbind($ds);
        return $mail;
    }
}
