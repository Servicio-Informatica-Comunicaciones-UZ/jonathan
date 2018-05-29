<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Respuesta;

?>

<div class="respuesta-form">

    <?php
    $r = new Respuesta();
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

    echo "\n\n";
    foreach ($models as $num => $respuesta) {
        echo Html::activeHiddenInput($respuesta, "[$num]pregunta_id") . "\n";
        echo Html::activeHiddenInput($respuesta, "[$num]propuesta_id") . "\n";
        echo $form->field($respuesta, "[$num]valor")
            ->label('<h2>' . Html::encode($respuesta->pregunta->titulo) . '</h2>')
            ->hint(
                Html::encode($respuesta->pregunta->descripcion) . '<br>' .
                sprintf(
                    Yii::t('jonathan', 'Máximo: %d caracteres, aprox. %d palabras'),
                    $respuesta->pregunta->max_longitud,
                    floor($respuesta->pregunta->max_longitud/5)
                )
            )
            ->textarea(['maxlength' => $respuesta->pregunta->max_longitud, 'rows' => 6]) . "\n\n";
    }

    echo "<hr>\n\n";

    echo $form->errorSummary($models);

    echo Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
            Yii::t('jonathan', 'Guardar'),
        [
            'id' => 'save-' . $r->formName(),
            'class' => 'btn btn-success',
        ]
    );

    ActiveForm::end();
    ?>

</div>
