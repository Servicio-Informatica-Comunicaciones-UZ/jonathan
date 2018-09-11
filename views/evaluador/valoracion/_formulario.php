<?php
/**
 * Fragmento de vista del formulario para añadir o editar una valoración.
 *
 * @author  Enrique Matías Sánchez <quique@unizar.es>
 * @license GPL-3.0+
 *
 * @see     https://gitlab.unizar.es/titulaciones/jonathan
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\models\Valoracion;

?>

<div class="valoracion-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'Valoracion',  // formName del modelo
        'layout' => 'horizontal',  // 'default',
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-danger',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n  {input}\n  {hint}\n  {error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                //'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ],
        ],
        // 'options' => ['enctype' => 'multipart/form-data'],
    ]);
    echo "\n\n";

    // attribute comentarios
    echo $form->field($model, 'comentarios', ['inputOptions' => ['placeholder' => 'Introduzca sus comentarios']])
        ->textArea(['maxlength' => true, 'rows' => 6]) . "\n\n";

    // attribute puntuacion
    if (!$model->bloque->tiene_puntuacion_interna) {
        echo $form->field($model, 'puntuacion')
            ->input('number', ['min' => 0.0, 'max' => 5.0, 'step' => 0.1])
            // ->input('range', ['min' => 0.0, 'max' => 5.0, 'step' => 0.1])
            ->hint(Yii::t('jonathan', 'De 0,0 a 5,0')) . "\n\n";
    }

    echo $form->errorSummary($model) . "\n";
    ?>

    <div class='form-group'>
        <div class='col-lg-offset-2 col-lg-10'>
            <?php
            echo Html::a(
                Yii::t('jonathan', 'Cancelar'),
                Yii::$app->request->referrer,  // \yii\helpers\Url::previous(),
                ['class' => 'btn btn-default']
            ) . "&nbsp;\n&nbsp;";

            echo Html::submitButton(
                '<span class="glyphicon glyphicon-check"></span> ' . Yii::t('jonathan', 'Guardar'),
                [
                    'id' => 'save-' . $model->formName(),
                    'class' => 'btn btn-success',
                ]
            ) . "\n";
            ?>
        </div>
    </div>
    <?php
    ActiveForm::end();
    ?>
</div>

