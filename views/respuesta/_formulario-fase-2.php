<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use marqu3s\summernote\Summernote;
use app\models\Respuesta;

?>

<div class="respuesta-form">

    <?php
    $r = new Respuesta();
    $form = ActiveForm::begin(
        [
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
        ]
    );

    echo "\n\n";
    foreach ($models as $num => $respuesta) {
        echo Html::activeHiddenInput($respuesta, "[$num]pregunta_id") . "\n";
        echo Html::activeHiddenInput($respuesta, "[$num]propuesta_id") . "\n";

        echo Summernote::widget(
            [
                'id' => "respuesta-{$num}-valor",
                'name' => "Respuesta[{$num}][valor]",
                'clientOptions' => ['lang' => 'es'],
            ]
        ) . "\n\n";
        echo "<p class='help-block>\n";
        echo Html::encode($respuesta->pregunta->descripcion) . "<br>\n";
        echo "</p>\n";
    }

    echo "<hr>\n\n";

    echo $form->errorSummary($models);

    echo Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' . Yii::t('jonathan', 'Guardar'),
        [
            'id' => 'save-' . $r->formName(),
            'class' => 'btn btn-success',
        ]
    );

    ActiveForm::end();
    ?>

</div>
