<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="propuesta-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'Propuesta',
        // 'layout' => 'vertical',
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-danger',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}<br>",
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                //'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]);
    ?>

    <!-- attribute denominacion -->
    <?php echo $form->field($model, 'denominacion')->textInput(['maxlength' => true]); ?>

    <!-- Tabla propuesta_macroarea -->
    <?php echo $form->field($model, 'propuestaMacroareas')->checkboxList(  // TODO: Poblar las checkboxes con el contenido de la tabla Macroarea
        [
            '1' => Yii::t('jonathan', 'Artes y Humanidades'),
            '2' => Yii::t('jonathan', 'Ciencias Sociales y Jurídicas'),
            '3' => Yii::t('jonathan', 'Ciencias de la Salud'),
            '4' => Yii::t('jonathan', 'Ingeniería y Arquitectura'),
            '5' => Yii::t('jonathan', 'Ciencias'),
        ]
        // ['separator' => '<br>']
    ); ?>

    <!-- Tabla propuesta_centro -->
    <?php echo $form->field($model, 'propuestaCentros[0]')->label('Centro 1')->textInput(['maxlength' => true]); ?>
    <?php echo $form->field($model, 'propuestaCentros[1]')->label('Centro 2')->textInput(['maxlength' => true]); ?>
    <?php echo $form->field($model, 'propuestaCentros[2]')->label('Centro 3')->textInput(['maxlength' => true]); ?>


    <!-- attribute nip -->
    <?php echo $form->field($model, 'nip')->hiddenInput(['value' => 999999])->label(false); ?> <!-- FIXME: nip del usuario -->

    <!-- attribute orientacion_id -->
    <?php
    echo $form->field($model, 'orientacion_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(app\models\Orientacion::find()->all(), 'id', 'id'),
        [
            'prompt' => 'Select',
            'disabled' => (isset($relAttributes) && isset($relAttributes['orientacion_id'])),
        ]
    ); ?>

    <!-- attribute creditos -->
    <?php echo $form->field($model, 'creditos')->textInput(); ?>

    <!-- attribute duracion -->
    <?php echo $form->field($model, 'duracion')->textInput(); ?>

    <!-- attribute modalidad_id -->
    <?php
    echo $form->field($model, 'modalidad_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(app\models\Modalidad::find()->all(), 'id', 'id'),
        [
            'prompt' => 'Select',
            'disabled' => (isset($relAttributes) && isset($relAttributes['modalidad_id'])),
        ]
    ); ?>

    <!-- attribute plazas -->
    <?php echo $form->field($model, 'plazas')->textInput(); ?>

    <!-- attribute tipo_estudio_id -->
    <?php echo $form->field($model, 'tipo_estudio_id')->hiddenInput(['value' => 6])->label(false); ?>

    <!-- attribute creditos_practicas -->
    <?php echo $form->field($model, 'creditos_practicas')->textInput(['maxlength' => true]); ?>

    <hr/>

    <?php echo $form->errorSummary($model); ?>

    <?php echo Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> '.($model->isNewRecord ? 'Create' : 'Save'),
        [
            'id' => 'save-'.$model->formName(),
            'class' => 'btn btn-success',
        ]
    );
    ?>

    <?php ActiveForm::end(); ?>

</div>

