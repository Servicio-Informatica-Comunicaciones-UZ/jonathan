<?php
use app\models\Macroarea;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<div class="propuesta-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'Propuesta',
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
    ?>

    <!-- attribute denominacion -->
    <?php echo $form->field(
        $model,
        'denominacion'
        // ['inputOptions' => ['placeholder' => $model->getAttributeLabel('denominacion')]]
    )->textInput(['maxlength' => true]); ?>

    <!-- Tabla propuesta_macroarea -->
    <?php echo $form->field($model, 'propuestaMacroareas')->inline()->checkboxList(
        ArrayHelper::map(Macroarea::find()->all(), 'id', 'nombre')
        // ['separator' => '<br>']
    )->label(Yii::t('jonathan', 'Macroárea(s)')); ?>

    <!-- Tabla propuesta_centro -->
    <?php // echo $form->field($model, 'propuestaCentros[0]')->label(Yii::t('jonathan', 'Centro(s)'));?>

    <div class="centros">
        <label class="control-label"><?php echo Yii::t('jonathan', 'Centro(s)'); ?></label>
    </div>
    <div class="anyadir_centro btn btn-info">
        <span class="glyphicon glyphicon-plus"></span> <?php echo Yii::t('jonathan', 'Añadir centro'); ?>
    </div>

    <?php $this->registerJs("
    $(document).ready(function() {
        var centros = $('.centros');
        var boton = $('.anyadir_centro');

        $(boton).click(function (e) {
            e.preventDefault();
            $(centros).append(\"<div><input type='text' class='form-control' name='Propuesta[propuestaCentros][]' style='display: inline; width: 90%'>\"
              + \" <div class='delete btn btn-danger'> <span class='glyphicon glyphicon-trash'></span> Borrar</div><br><br></div>\");
        });

        $(centros).on('click', '.delete', function (e) {
            e.preventDefault();
            $(this).parent('div').remove();
        });
    });
    "); ?>

    <!-- attribute nip -->
    <?php echo $form->field($model, 'nip')->hiddenInput(['value' => 999999])->label(false); ?> <!-- FIXME: nip del usuario -->

    <!-- attribute orientacion_id -->
    <?php
    echo $form->field($model, 'orientacion_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(app\models\Orientacion::find()->all(), 'id', 'nombre'),
        [
            'prompt' => Yii::t('jonathan', 'Seleccione la orientación'),
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
        \yii\helpers\ArrayHelper::map(app\models\Modalidad::find()->all(), 'id', 'nombre'),
        [
            'prompt' => Yii::t('jonathan', 'Seleccione la modalidad'),
            'disabled' => (isset($relAttributes) && isset($relAttributes['modalidad_id'])),
        ]
    ); ?>

    <!-- attribute plazas -->
    <?php echo $form->field($model, 'plazas')->textInput(); ?>

    <!-- attribute tipo_estudio_id -->
    <?php echo $form->field($model, 'tipo_estudio_id')->hiddenInput(['value' => 6])->label(false); ?>

    <!-- attribute creditos_practicas -->
    <?php echo $form->field($model, 'creditos_practicas')->textInput(['maxlength' => true]); ?>

    <!-- Tabla propuesta_titulacion -->

    <div class="titulaciones">
        <label class="control-label"><?php echo Yii::t('jonathan', 'Titulaciones a las que va dirigido'); ?></label>
    </div>
    <div class="anyadir_titulacion btn btn-info">
        <span class="glyphicon glyphicon-plus"></span> <?php echo Yii::t('jonathan', 'Añadir titulación'); ?>
    </div>

    <?php $this->registerJs("
    $(document).ready(function() {
        var titulaciones = $('.titulaciones');
        var boton = $('.anyadir_titulacion');

        $(boton).click(function (e) {
            e.preventDefault();
            $(titulaciones).append(\"<div><input type='text' class='form-control' name='Propuesta[propuestaTitulaciones][]' style='display: inline; width: 90%'>\"
              + \" <div class='delete btn btn-danger'> <span class='glyphicon glyphicon-trash'></span> Borrar</div><br><br></div>\");
        });

        $(titulaciones).on('click', '.delete', function (e) {
            e.preventDefault();
            $(this).parent('div').remove();
        });
    });
    "); ?>
    <!-- Tabla propuesta_doctorado -->

    <div class="doctorados">
        <label class="control-label"><?php echo Yii::t('jonathan', 'Programas de doctorado a los que podría dar acceso'); ?></label>
    </div>
    <div class="anyadir_doctorado btn btn-info">
        <span class="glyphicon glyphicon-plus"></span> <?php echo Yii::t('jonathan', 'Añadir programa de doctorado'); ?>
    </div>

    <?php $this->registerJs("
    $(document).ready(function() {
        var doctorados = $('.doctorados');
        var boton = $('.anyadir_doctorado');

        $(boton).click(function (e) {
            e.preventDefault();
            $(doctorados).append(\"<div><input type='text' class='form-control' name='Propuesta[propuestaDoctorados][]' style='display: inline; width: 90%'>\"
              + \" <div class='delete btn btn-danger'> <span class='glyphicon glyphicon-trash'></span> Borrar</div><br><br></div>\");
        });

        $(doctorados).on('click', '.delete', function (e) {
            e.preventDefault();
            $(this).parent('div').remove();
        });
    });
    "); ?>
    <!-- Tabla propuesta_grupo_inves -->

    <div class="grupos">
        <label class="control-label"><?php echo Yii::t('jonathan', 'Grupos de investigación reconocidos por el Gobierno de Aragón que apoyan la propuesta'); ?></label>
    </div>
    <div class="anyadir_grupo btn btn-info">
        <span class="glyphicon glyphicon-plus"></span> <?php echo Yii::t('jonathan', 'Añadir grupo de investigación'); ?>
    </div>

    <?php $this->registerJs("
    $(document).ready(function() {
        var grupos = $('.grupos');
        var boton = $('.anyadir_grupo');

        $(boton).click(function (e) {
            e.preventDefault();
            $(grupos).append(\"<div><input type='text' class='form-control' name='Propuesta[propuestaGruposInves][]' style='display: inline; width: 90%'>\"
              + \" <div class='delete btn btn-danger'> <span class='glyphicon glyphicon-trash'></span> Borrar</div><br><br></div>\");
        });

        $(doctorados).on('click', '.delete', function (e) {
            e.preventDefault();
            $(this).parent('div').remove();
        });
    });
    "); ?>

    <hr/>

    <?php echo $form->errorSummary($model); ?>

    <?php echo Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> '.
          ($model->isNewRecord ? Yii::t('jonathan', 'Crear') : Yii::t('jonathan', 'Guardar')),
        [
            'id' => 'save-'.$model->formName(),
            'class' => 'btn btn-success',
        ]
    );
    ?>

    <?php
    ActiveForm::end();
    ?>
</div>

