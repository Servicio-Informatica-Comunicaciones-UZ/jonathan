<?php
/*
 * This file must returns the OneLogin_Saml configuration.
 * See https://github.com/onelogin/php-saml/blob/master/settings_example.php
 */
$urlManager = Yii::$app->urlManager;
$spBaseUrl = $urlManager->getHostInfo() . $urlManager->getBaseUrl();

return [
    // Enable debug mode (to print errors)
    'debug' => true,
    // Service Provider Data that we are deploying
    'sp' => [
        // Identifier of the SP entity (must be a URI)
        'entityId' => $spBaseUrl . '/saml/metadata',
        // Specifies info about where and how the <AuthnResponse> message MUST be
        // returned to the requester, in this case our SP.
        'assertionConsumerService' => [
            // URL Location where the <Response> from the IdP will be returned
            'url' => $spBaseUrl . '/saml/acs',
            // SAML protocol binding to be used when returning the <Response>
            // message.  Onelogin Toolkit supports for this endpoint the
            // HTTP-Redirect binding only
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        ],
        // Specifies info about where and how the <Logout Response> message MUST be
        // returned to the requester, in this case our SP.
        'singleLogoutService' => [
            // URL Location where the <Response> from the IdP will be returned
            'url' => $spBaseUrl . '/saml/sls',
            // SAML protocol binding to be used when returning the <Response>
            // message.  Onelogin Toolkit supports for this endpoint the
            // HTTP-Redirect binding only
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],
        // Specifies constraints on the name identifier to be used to
        // represent the requested subject.
        // Take a look on lib/Saml2/Constants.php to see the NameIdFormat supported
        //'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
        'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
    ],
    // Identity Provider Data that we want connect with our SP
    'idp' => [
        // Identifier of the IdP entity (must be a URI)
        'entityId' => 'FIXME',
        // SSO endpoint info of the IdP. (Authentication Request protocol)
        'singleSignOnService' => [
            // URL Target of the IdP where the SP will send the Authentication Request Message
            'url' => 'https://FIXME.idp.com/sso',
            // SAML protocol binding to be used when returning the <Response>
            // message.  Onelogin Toolkit supports for this endpoint the
            // HTTP-POST binding only
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect'
        ],
        // SLO endpoint info of the IdP.
        'singleLogoutService' => [
            // URL Location of the IdP where the SP will send the SLO Request
            'url' => 'https://FIXME.idp.com/sls',
            // SAML protocol binding to be used when returning the <Response>
            // message.  Onelogin Toolkit supports for this endpoint the
            // HTTP-Redirect binding only
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],
        // Public x509 certificate of the IdP
        'x509cert' => '<FIXME x509cert string>',
    ],
];
