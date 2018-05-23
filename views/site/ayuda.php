<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('app', 'Ayuda');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <h1><?php echo Html::encode($this->title); ?></h1>
    <hr><br>

    <h2>Soporte administrativo</h2>

    <p>Contacte con la Dirección de Organización Académica &lt;diroa@unizar.es&gt;.</p>


    <h2>Soporte técnico</h2>

    <p>Abra un ticket en <?php echo Html::a('Ayudica', 'https://ayudica.unizar.es/otrs/customer.pl'); ?>.</p>
</div>
