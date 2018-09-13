<?php

use yii\helpers\Html;

$this->title = sprintf(Yii::t('gestion', 'Añadir usuario al rol «%s»'), $rol);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gestión'), 'url' => ['//gestion/index']];
$this->params['breadcrumbs'][] = [
    'label' => sprintf(Yii::t('models', 'Usuarios del rol «%s»'), $rol),
    'url' => ['listado', 'rol' => $rol],
];
$this->params['breadcrumbs'][] = $this->title;

// Change background color
$this->registerCssFile('@web/css/gestion.css', ['depends' => 'app\assets\AppAsset']);
?>


<h1><?php echo Html::encode($this->title); ?></h1>
<hr><br>

<?php
echo Html::beginForm('', 'post', ['class' => 'form-horizontal']) . "\n\n";

echo Html::beginTag('div', ['class' => 'form-group']) . "\n";
echo Html::label(Yii::t('app', 'Número de Identificación Personal'), 'nip', ['class' => 'control-label col-sm-3']) . "\n";
echo Html::beginTag('div', ['class' => 'col-sm-7']) . "\n";
echo Html::input(
    'number',
    'nip',
    null,
    ['id' => 'nip', 'min' => 0, 'max' => 999999, 'class' => 'form-control no-spinners', 'placeholder' => Yii::t('gestion', 'Introduzca un NIP')]
) . "\n";
echo Html::endTag('div') . "\n";
echo Html::endTag('div') . "\n\n";

echo Html::beginTag('div', ['class' => 'form-group']) . "\n";
echo Html::beginTag('div', ['class' => 'col-lg-offset-3 col-lg-7']) . "\n";
echo Html::submitButton(Yii::t('gestion', 'Añadir'), ['class' => 'btn btn-success']) . "\n";
echo Html::endTag('div') . "\n";
echo Html::endTag('div') . "\n";

echo Html::endForm() . "\n\n";
