<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\PropuestaSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="propuesta-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'anyo') ?>

		<?= $form->field($model, 'user_id') ?>

		<?= $form->field($model, 'denominacion') ?>

		<?= $form->field($model, 'orientacion_id') ?>

		<?php // echo $form->field($model, 'creditos') ?>

		<?php // echo $form->field($model, 'duracion') ?>

		<?php // echo $form->field($model, 'modalidad_id') ?>

		<?php // echo $form->field($model, 'plazas') ?>

		<?php // echo $form->field($model, 'creditos_practicas') ?>

		<?php // echo $form->field($model, 'tipo_estudio_id') ?>

		<?php // echo $form->field($model, 'estado_id') ?>

		<?php // echo $form->field($model, 'log') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cruds', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('cruds', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
