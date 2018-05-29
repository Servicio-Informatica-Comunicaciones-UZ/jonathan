<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('jonathan', 'Editar respuesta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuestas'), 'url' => ['propuesta/listado']];
$this->params['breadcrumbs'][] = [
    'label' => $model->propuesta->denominacion,
    'url' => ['propuesta/ver', 'id' => $model->propuesta_id]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>
    <?php echo $this->title; ?>
    <small>
        <?php echo Html::encode($model->propuesta->denominacion); ?>
    </small>
</h1>
<hr><br>

<div class="respuesta-form">
    <?php
    $form = ActiveForm::begin([
        'id' => 'respuesta',
        'layout' => 'default',
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-danger',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                //'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]);

    echo Html::activeHiddenInput($model, 'pregunta_id') . "\n";
    echo Html::activeHiddenInput($model, 'propuesta_id') . "\n";
    echo $form->field($model, 'valor')
        ->label('<h2>' . Html::encode($model->pregunta->titulo) . '</h2>')
        ->hint(Html::encode($model->pregunta->descripcion) . '<br>' .
            sprintf(Yii::t('jonathan', 'Máximo: %d caracteres'), $model->pregunta->max_longitud))
        ->textarea(['maxlength' => $model->pregunta->max_longitud, 'rows' => 6]) . "\n\n";

    echo $form->errorSummary($model) . "\n";

    echo "<div class='form-group'>\n";
    echo Html::a(
        Yii::t('jonathan', 'Cancelar'),
        \yii\helpers\Url::previous(),
        ['class' => 'btn btn-default']
    ) . "&nbsp;\n&nbsp;";

    echo Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
            Yii::t('jonathan', 'Guardar'),
        [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-success',
        ]
    ) . "\n";
    echo "</div>\n";

    ActiveForm::end();
    ?>
</div>
