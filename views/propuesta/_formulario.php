<?php
use app\models\FicheroPdf;
use app\models\Macroarea;
use app\models\PropuestaCentro;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

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
        'options' => ['enctype' => 'multipart/form-data'],
    ]);

    // attribute denominacion
    echo $form->field(
        $model,
        'denominacion'
        // ['inputOptions' => ['placeholder' => $model->getAttributeLabel('denominacion')]]
    )->textInput(['maxlength' => true]);

    // Tabla propuesta_macroarea
    // $checks = $model->getPropuestaMacroareas()->select('macroarea_id')->asArray()->column();
    $checks = array_column($model->propuestaMacroareas, 'macroarea_id');
    echo $form->field($model, 'propuestaMacroareas')->inline()->checkboxList(
        ArrayHelper::map(Macroarea::find()->all(), 'id', 'nombre'),
        ['value' => $checks]  // , 'separator' => '<br>']
    )->label(Yii::t('jonathan', 'Macroárea(s)'));

    // Tabla propuesta_centro
    $pc = new PropuestaCentro();
    ?>
    <div class='cabecera-azul'>
        <label class="control-label"><?php echo Yii::t('jonathan', 'Centro(s)'); ?></label>
        <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th><?php echo $pc->getAttributeLabel('nombre_centro'); ?></th>
                <th><?php echo $pc->getAttributeLabel('documento_firma'); ?></th>
                <th></th>
            </tr>
        </thead>

        <tbody class="centros" id='centros'>
        <?php

        foreach ($model->propuestaCentros as $num => $centro) {
            $doc = new FicheroPdf();
            echo '<tr>';
            echo '<td>' . Html::activeHiddenInput($centro, "[{$num}]id", $options = []);
            echo $form->field($centro, "[{$num}]nombre_centro")->label(false)->textInput(['maxlength' => true]) . "</td>\n";
            echo '<td>';
            if ($centro->documento_firma) {
                echo Html::a(
                    $centro->documento_firma,
                    Url::home() . "pdf/firmas_centros/{$centro->id}.pdf"
                );
            }
            echo $form->field($doc, "[{$num}]fichero")->label(false)->fileInput([
                'class' => 'btn filestyle',
                // 'data-badge' => false,
                'data-buttonBefore' => 'true',
                'data-buttonText' => Yii::t('jonathan', 'Reemplazar documento'),
                // 'data-disabled' => 'true',
                'data-icon' => 'false',
                // 'data-iconName' => 'glyphicon glyphicon-folder-open',
                // 'data-input' => 'false',
                'data-placeholder' => $centro->documento_firma,
                // 'data-size' => 'sm',
                'accept' => '.pdf',
            ]) . "</td>\n";
            echo '<td>' . Button::widget([
                'label' => "<span class='glyphicon glyphicon-trash'></span> " . Yii::t('jonathan', 'Borrar'),
                'encodeLabel' => false,
                'options' => ['class' => 'delete btn btn-danger'],
            ]) . "</td>\n";
            echo "</tr>\n";
        }
        ?>
        </tbody>
        </table>
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
            var num = document.getElementById('centros').childElementCount;
            $(centros).append(\"<tr>\"
              + \"<td><div class='form-group field-propuestacentro-\"+num+\"-nombre_centro'>\"
              + \"  <div>\"
              + \"    <input id='propuestacentro-\"+num+\"-nombre_centro' class='form-control' name='PropuestaCentro[\"+num+\"][nombre_centro]' maxlength='250' type='text'>\"
              + \"    <p class='help-block help-block-error'></p>\"
              + \"  </div></div>\"
              + \"</td>\"
              + \"<td><div class='form-group field-ficheropdf-\"+num+\"-fichero'>\"
              + \"  <div>\"
              + \"    <input name='FicheroPdf[\"+num+\"][fichero]' value='' type='hidden'>\"
              + \"    <input accept='.pdf' id='ficheropdf-\"+num+\"-fichero' class='btn filestyle'\"
              + \"      name='FicheroPdf[\"+num+\"][fichero]' type='file' data-buttonbefore='true' data-icon='false'\"
              + \"      data-buttonText='Seleccionar documento'>\"
              + \"    <p class='help-block help-block-error'></p>\"
              + \"  </div></div></td>\"
              + \"<td><div class='delete btn btn-danger'> <span class='glyphicon glyphicon-trash'></span> Borrar</div></td>\"
              + \"</tr>\");
            // Filestyle
            $('.filestyle').each(function() {
                var \$this = $(this), options = {
                    'input' : \$this.attr('data-input') !== 'false',
                    'icon' : \$this.attr('data-icon') !== 'false',
                    'buttonBefore' : \$this.attr('data-buttonBefore') === 'true',
                    'disabled' : \$this.attr('data-disabled') === 'true',
                    'size' : \$this.attr('data-size'),
                    'buttonText' : \$this.attr('data-buttonText'),
                    'buttonName' : \$this.attr('data-buttonName'),
                    'iconName' : \$this.attr('data-iconName'),
                    'badge' : \$this.attr('data-badge') !== 'false',
                    'placeholder': \$this.attr('data-placeholder')
                };
                \$this.filestyle(options);
            });
        });

        $(centros).on('click', '.delete', function (e) {
            e.preventDefault();
            $(this).parent('td').parent('tr').remove();
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

    <!-- attribute anyo -->
    <?php echo $form->field($model, 'anyo')->hiddenInput(['value' => date('Y')])->label(false); ?>

    <!-- attribute creditos_practicas -->
    <?php echo $form->field($model, 'creditos_practicas')->textInput(['maxlength' => true]); ?>

    <!-- Tabla propuesta_titulacion -->
    <div class="titulaciones">
        <label class="control-label"><?php echo Yii::t('jonathan', 'Titulaciones a las que va dirigido'); ?></label>
        <?php
        foreach ($model->propuestaTitulacions as $titulacion) {
            echo "<div><input type='text' class='form-control' name='PropuestaTitulacion[][nombre_titulacion]' value='{$titulacion->nombre_titulacion}' maxlength='250' style='display: inline; width: 90%;'>";
            echo "  <div class='delete btn btn-danger'> <span class='glyphicon glyphicon-trash'></span> Borrar</div><br><br></div>";
        }
        ?>
    </div>
    <div class="anyadir_titulacion btn btn-info">
        <span class="glyphicon glyphicon-plus"></span> <?php echo Yii::t('jonathan', 'Añadir titulación'); ?>
    </div><br><br>

    <?php $this->registerJs("
    $(document).ready(function() {
        var titulaciones = $('.titulaciones');
        var boton = $('.anyadir_titulacion');

        $(boton).click(function (e) {
            e.preventDefault();
            $(titulaciones).append(\"<div><input type='text' class='form-control' name='PropuestaTitulacion[][nombre_titulacion]' maxlength='250' style='display: inline; width: 90%;'>\"
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
        <?php
        foreach ($model->propuestaDoctorados as $doctorado) {
            echo "<div><input type='text' class='form-control' name='PropuestaDoctorado[][nombre_doctorado]' value='{$doctorado->nombre_doctorado}' maxlength='250' style='display: inline; width: 90%;'>";
            echo "  <div class='delete btn btn-danger'> <span class='glyphicon glyphicon-trash'></span> Borrar</div><br><br></div>";
        }
        ?>
    </div>
    <div class="anyadir_doctorado btn btn-info">
        <span class="glyphicon glyphicon-plus"></span> <?php echo Yii::t('jonathan', 'Añadir programa de doctorado'); ?>
    </div><br><br>

    <?php $this->registerJs("
    $(document).ready(function() {
        var doctorados = $('.doctorados');
        var boton = $('.anyadir_doctorado');

        $(boton).click(function (e) {
            e.preventDefault();
            $(doctorados).append(\"<div><input type='text' class='form-control' name='PropuestaDoctorado[][nombre_doctorado]' maxlength='250' style='display: inline; width: 90%;'>\"
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
        <?php
        foreach ($model->propuestaGrupoInves as $grupo) {
            echo "<div><input type='text' class='form-control' name='PropuestaGrupoInves[][nombre_grupo_inves]' value='{$grupo->nombre_grupo_inves}' maxlength='250' style='display: inline; width: 90%;'>";
            echo "  <div class='delete btn btn-danger'> <span class='glyphicon glyphicon-trash'></span> Borrar</div><br><br></div>";
        }
        ?>
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
            $(grupos).append(\"<div><input type='text' class='form-control' name='PropuestaGrupoInves[][nombre_grupo_inves]' maxlength='250' style='display: inline; width: 90%;'>\"
              + \" <div class='delete btn btn-danger'> <span class='glyphicon glyphicon-trash'></span> Borrar</div><br><br></div>\");
        });

        $(grupos).on('click', '.delete', function (e) {
            e.preventDefault();
            $(this).parent('div').remove();
        });
    });
    "); ?>

    <hr>

    <?php
    echo $form->errorSummary($model) . "\n";

    echo "<div class='form-group'>\n";
    echo Html::a(
        Yii::t('jonathan', 'Cancelar'),
        \yii\helpers\Url::previous(),
        ['class' => 'btn btn-default']
    ) . "&nbsp;\n&nbsp;";

    echo Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
          ($model->isNewRecord ? Yii::t('jonathan', 'Continuar') : Yii::t('jonathan', 'Guardar')),
        [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-success',
        ]
    ) . "\n";
    echo "</div>\n";

    ActiveForm::end();
    ?>
</div>

