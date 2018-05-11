<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\VarDumper;

$this->title = 'Session';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-session">
    <h2>Yii::$app->user attributes</h2>

    <?php
    echo(Yii::$app->user->isGuest ? 'Guest' : 'Authenticated') . "<br>\n";
    echo 'Yii id: ' . Yii::$app->user->getId() . "<br>\n";
    echo 'Username: ' . (Yii::$app->user->identity ? Yii::$app->user->identity->username : '') . "<br>\n";
    echo '$enableSession: ' . (Yii::$app->user->enableSession ? 'true' : 'false');
    ?>

    <h2>Session keys</h2>
    <?php
    $session = Yii::$app->session;
    foreach ($session as $name => $value) {
        echo "Name: $name <br>\n";
    }
    ?>

    <h2>SAML attributes</h2>
    <pre>
    <?php
    if ($session->has('saml_attributes')) {
        VarDumper::dump($session->get('saml_attributes'));
    }
    ?>
    </pre>
</div>
