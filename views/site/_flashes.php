<?php
/**
 * Fragmento de vista que muestra los mensajes Flash de una sesión.
 *
 * @author  Enrique Matías Sánchez <quique@unizar.es>
 * @license GPL-3.0+
 */
use yii\bootstrap\Alert;
use yii\helpers\Html;

// Giiant usa 'error'
if (Yii::$app->session->hasFlash('error')) {
    $flashes = Yii::$app->session->getFlash('error');
    if (!is_array($flashes)) {  // Flash establecido mediante setFlash() y no addFlash()
        $flashes = [$flashes];
    }
    foreach ($flashes as $msg) {
        echo Alert::widget([
            'body' => "<span class='glyphicon glyphicon-remove-sign'></span>" . nl2br(Html::encode($msg)),
            'options' => ['class' => 'alert-danger'],
        ]) . "\n\n";
    }
}

// Bootstrap 3 ofrece 4 clases de alertas: danger, warning, info & success
if (Yii::$app->session->hasFlash('danger')) {
    $flashes = Yii::$app->session->getFlash('danger');
    if (!is_array($flashes)) {  // Flash establecido mediante setFlash() y no addFlash()
        $flashes = [$flashes];
    }
    foreach ($flashes as $msg) {
        echo Alert::widget([
            'body' => "<span class='glyphicon glyphicon-remove-sign'></span>" . nl2br(Html::encode($msg)),
            'options' => ['class' => 'alert-danger'],
        ]) . "\n\n";
    }
}

if (Yii::$app->session->hasFlash('warning')) {
    $flashes = Yii::$app->session->getFlash('warning');
    if (!is_array($flashes)) {  // Flash establecido mediante setFlash() y no addFlash()
        $flashes = [$flashes];
    }
    foreach ($flashes as $msg) {
        echo Alert::widget([
            'body' => "<span class='glyphicon glyphicon-exclamation-sign'></span>" . nl2br(Html::encode($msg)),
            'options' => ['class' => 'alert-warning'],
        ]) . "\n\n";
    }
}

if (Yii::$app->session->hasFlash('info')) {
    $flashes = Yii::$app->session->getFlash('info');
    if (!is_array($flashes)) {  // Flash establecido mediante setFlash() y no addFlash()
        $flashes = [$flashes];
    }
    foreach ($flashes as $msg) {
        echo Alert::widget([
            'body' => "<span class='glyphicon glyphicon-info-sign'></span>" . nl2br(Html::encode($msg)),
            'options' => ['class' => 'alert-info'],
        ]) . "\n\n";
    }
}

if (Yii::$app->session->hasFlash('success')) {
    $flashes = Yii::$app->session->getFlash('success');
    if (!is_array($flashes)) {  // Flash establecido mediante setFlash() y no addFlash()
        $flashes = [$flashes];
    }
    foreach ($flashes as $msg) {
        echo Alert::widget([
            'body' => "<span class='glyphicon glyphicon-ok-sign'></span>" . nl2br(Html::encode($msg)),
            'options' => ['class' => 'alert-success'],
        ]) . "\n\n";
    }
}


// Si tenemos la seguridad de que el mensaje es seguro, podemos no codificarlo.
// Útil para incluir links u otro código HTML.
if (Yii::$app->session->hasFlash('safe-danger')) {
    $flashes = Yii::$app->session->getFlash('safe-danger');
    if (!is_array($flashes)) {  // Flash establecido mediante setFlash() y no addFlash()
        $flashes = [$flashes];
    }
    foreach ($flashes as $msg) {
        echo Alert::widget([
            'body' => "<span class='glyphicon glyphicon-remove-sign'></span>" . nl2br($msg),
            'options' => ['class' => 'alert-danger'],
        ]) . "\n\n";
    }
}

if (Yii::$app->session->hasFlash('safe-warning')) {
    $flashes = Yii::$app->session->getFlash('safe-warning');
    if (!is_array($flashes)) {  // Flash establecido mediante setFlash() y no addFlash()
        $flashes = [$flashes];
    }
    foreach ($flashes as $msg) {
        echo Alert::widget([
            'body' => "<span class='glyphicon glyphicon-exclamation-sign'></span>" . nl2br($msg),
            'options' => ['class' => 'alert-warning'],
        ]) . "\n\n";
    }
}

if (Yii::$app->session->hasFlash('safe-info')) {
    $flashes = Yii::$app->session->getFlash('safe-info');
    if (!is_array($flashes)) {  // Flash establecido mediante setFlash() y no addFlash()
        $flashes = [$flashes];
    }
    foreach ($flashes as $msg) {
        echo Alert::widget([
            'body' => "<span class='glyphicon glyphicon-info-sign'></span>" . nl2br($msg),
            'options' => ['class' => 'alert-info'],
        ]) . "\n\n";
    }
}

if (Yii::$app->session->hasFlash('safe-success')) {
    $flashes = Yii::$app->session->getFlash('safe-success');
    if (!is_array($flashes)) {  // Flash establecido mediante setFlash() y no addFlash()
        $flashes = [$flashes];
    }
    foreach ($flashes as $msg) {
        echo Alert::widget([
            'body' => "<span class='glyphicon glyphicon-ok-sign'></span>" . nl2br($msg),
            'options' => ['class' => 'alert-success'],
        ]) . "\n\n";
    }
}
