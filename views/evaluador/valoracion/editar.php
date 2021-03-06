<?php

use yii\helpers\Html;

$this->title = Yii::t('evaluador', 'Editar evaluación');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuestas asignadas'), 'url' => ['evaluador/index']];
$this->params['breadcrumbs'][] = [
    'label' => $model->propuesta->denominacion,
    'url' => ['//evaluador/propuesta/ver', 'propuesta_id' => $model->propuesta_id],
];
$this->params['breadcrumbs'][] = $this->title;

// Change background color
$this->registerCssFile('@web/css/gestion.css', ['depends' => 'app\assets\AppAsset']);
?>


<h1><?php echo Html::encode($this->title); ?></h1>
<hr><br>

<?php if ($model->respuesta) {
    ?>
    <h2><?php echo Html::encode($model->respuesta->pregunta->titulo); ?></h2>
    <p class='pregunta'><strong><?php echo Html::encode($model->respuesta->pregunta->descripcion); ?></strong></p>
    <p><?php echo nl2br(Html::encode($model->respuesta->valor)); ?></p>
    <?php
} ?>

<div class='cuadro-gris'>
    <h3><?php echo "{$model->bloque->titulo} ({$model->bloque->porcentaje}%)"; ?></h3>
    <p style='font-weight: bold;'><?php echo nl2br(Html::encode($model->bloque->descripcion)); ?></p>

    <?php echo $this->render('_formulario', ['model' => $model]); ?>
</div>
