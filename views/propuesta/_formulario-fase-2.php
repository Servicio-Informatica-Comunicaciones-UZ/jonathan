<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\ConvenioIntercambios;
use app\models\ConvenioPracticas;
use app\models\Estado;
use app\models\FicheroPdf;
use app\models\Macroarea;
use app\models\Propuestaconvenio;
use app\models\PropuestaGrupoInves;

$max_filesize = ini_get('upload_max_filesize');
?>

<div class="propuesta-form">

    <?php
    $form = ActiveForm::begin(
        [
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
        ]
    );

    // PDF de la Memoria de verificación
    echo "<p><label class='control-label'>" . $model->getAttributeLabel('memoria_verificacion') . "</label></p>\n";
    $doc = new FicheroPdf();
    if ($model->memoria_verificacion) {
        echo Html::a(
            $model->memoria_verificacion,
            Url::home() . "pdf/memorias_verificacion/{$model->id}.pdf"
        );
    }
    echo $form->field($doc, "[memoria_verificacion]fichero")->label(false)->fileInput(
        [
        'class' => 'btn filestyle',
        // 'data-badge' => false,
        'data-buttonBefore' => 'true',
        'data-buttonText' => $model->memoria_verificacion ? Yii::t('jonathan', 'Reemplazar documento') : Yii::t('jonathan', 'Seleccionar documento'),
        // 'data-disabled' => 'true',
        'data-icon' => 'false',
        // 'data-iconName' => 'glyphicon glyphicon-folder-open',
        // 'data-input' => 'false',
        'data-placeholder' => $model->memoria_verificacion,
        // 'data-size' => 'sm',
        'accept' => '.pdf',
        ]
    )->hint(Yii::t('jonathan', 'Tamaño máximo: ') . $max_filesize) . "\n";


    // PDF de la Memoria económica
    echo "<p><label class='control-label'>" . $model->getAttributeLabel('memoria_economica') . "</label></p>\n";
    $doc = new FicheroPdf();
    if ($model->memoria_economica) {
        echo Html::a(
            $model->memoria_economica,
            Url::home() . "pdf/memorias_economicas/{$model->id}.pdf"
        );
    }
    echo $form->field($doc, '[memoria_economica]fichero')->label(false)->fileInput(
        [
        'class' => 'btn filestyle',
        // 'data-badge' => false,
        'data-buttonBefore' => 'true',
        'data-buttonText' => $model->memoria_economica ? Yii::t('jonathan', 'Reemplazar documento') : Yii::t('jonathan', 'Seleccionar documento'),
        // 'data-disabled' => 'true',
        'data-icon' => 'false',
        // 'data-iconName' => 'glyphicon glyphicon-folder-open',
        // 'data-input' => 'false',
        'data-placeholder' => $model->memoria_economica,
        // 'data-size' => 'sm',
        'accept' => '.pdf',
        ]
    )->hint(Yii::t('jonathan', 'Tamaño máximo: ') . $max_filesize) . "\n";


    // Tabla convenio_practicas
    $cp = new ConvenioPracticas();
    ?>
    <div class='cabecera-azul table-responsive'>
        <label class="control-label"><?php echo Yii::t('jonathan', 'Prácticas externas'); ?></label>
        <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th><?php echo $cp->getAttributeLabel('nombre_entidad'); ?></th>
                <th><?php echo $cp->getAttributeLabel('documento'); ?></th>
                <th></th>
            </tr>
        </thead>

        <tbody class="practicas" id='practicas'>
        <?php

        foreach ($model->convenioPracticas as $num => $convenio) {
            $doc = new FicheroPdf();
            echo '<tr>';
            echo '<td>' . Html::activeHiddenInput($convenio, "[{$num}]id", $options = []);
            echo $form->field($convenio, "[{$num}]nombre_entidad")->label(false)->textInput(['maxlength' => true]) . "</td>\n";
            echo '<td>';
            if ($convenio->documento) {
                echo Html::a(
                    $convenio->documento,
                    Url::home() . "pdf/convenios_practicas/{$convenio->id}.pdf"
                );
            }
            echo $form->field($doc, "[practicas-{$num}]fichero")->label(false)->fileInput([
                'class' => 'btn filestyle',
                // 'data-badge' => false,
                'data-buttonBefore' => 'true',
                'data-buttonText' => Yii::t('jonathan', 'Reemplazar documento'),
                // 'data-disabled' => 'true',
                'data-icon' => 'false',
                // 'data-iconName' => 'glyphicon glyphicon-folder-open',
                // 'data-input' => 'false',
                'data-placeholder' => $convenio->documento,
                // 'data-size' => 'sm',
                'accept' => '.pdf',
            ])->hint(Yii::t('jonathan', 'Tamaño máximo: ') . $max_filesize) . "</td>\n";
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

    <div class="anyadir_practicas btn btn-info">
        <span class="glyphicon glyphicon-plus"></span> <?php echo Yii::t('jonathan', 'Añadir convenio'); ?>
    </div><br><br>

    <?php $this->registerJs("
    $(document).ready(function() {
        var practicas = $('.practicas');
        var boton = $('.anyadir_practicas');

        $(boton).click(function (e) {
            e.preventDefault();
            var num = document.getElementById('practicas').childElementCount;
            $(practicas).append(\"<tr>\"
              + \"<td><div class='form-group field-practicas-\"+num+\"-nombre_entidad'>\"
              + \"  <div>\"
              + \"    <input id='practicas-\"+num+\"-nombre_entidad' class='form-control' name='ConvenioPracticas[\"+num+\"][nombre_entidad]' maxlength='250' type='text'>\"
              + \"    <p class='help-block help-block-error'></p>\"
              + \"  </div></div>\"
              + \"</td>\"
              + \"<td><div class='form-group field-ficheropdf-\"+num+\"-fichero'>\"
              + \"  <div>\"
              + \"    <input name='FicheroPdf[practicas-\"+num+\"][fichero]' value='' type='hidden'>\"
              + \"    <input accept='.pdf' id='ficheropdf-practicas-\"+num+\"-fichero' class='btn filestyle'\"
              + \"      name='FicheroPdf[practicas-\"+num+\"][fichero]' type='file' data-buttonbefore='true' data-icon='false'\"
              + \"      data-buttonText='Seleccionar documento'>\"
              + \"    <p class='help-block'>Tamaño máximo: $max_filesize</p>\"
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

        $(practicas).on('click', '.delete', function (e) {
            e.preventDefault();
            $(this).parent('td').parent('tr').remove();
        });
    });
    ");


    // Tabla convenio_intercambios
    $ci = new ConvenioIntercambios();
    ?>
    <div class='cabecera-azul table-responsive'>
        <label class="control-label"><?php echo Yii::t('jonathan', 'Intercambios internacionales'); ?></label>
        <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th><?php echo $ci->getAttributeLabel('nombre_entidad'); ?></th>
                <th><?php echo $ci->getAttributeLabel('documento'); ?></th>
                <th></th>
            </tr>
        </thead>

        <tbody class="intercambios" id='intercambios'>
        <?php

        foreach ($model->convenioIntercambios as $num => $convenio) {
            $doc = new FicheroPdf();
            echo '<tr>';
            echo '<td>' . Html::activeHiddenInput($convenio, "[{$num}]id", $options = []);
            echo $form->field($convenio, "[{$num}]nombre_entidad")->label(false)->textInput(['maxlength' => true]) . "</td>\n";
            echo '<td>';
            if ($convenio->documento) {
                echo Html::a(
                    $convenio->documento,
                    Url::home() . "pdf/convenios_intercambios/{$convenio->id}.pdf"
                );
            }
            echo $form->field($doc, "[intercambios-{$num}]fichero")->label(false)->fileInput([
                'class' => 'btn filestyle',
                // 'data-badge' => false,
                'data-buttonBefore' => 'true',
                'data-buttonText' => Yii::t('jonathan', 'Reemplazar documento'),
                // 'data-disabled' => 'true',
                'data-icon' => 'false',
                // 'data-iconName' => 'glyphicon glyphicon-folder-open',
                // 'data-input' => 'false',
                'data-placeholder' => $convenio->documento,
                // 'data-size' => 'sm',
                'accept' => '.pdf',
            ])->hint(Yii::t('jonathan', 'Tamaño máximo: ') . $max_filesize) . "</td>\n";
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

    <div class="anyadir_intercambios btn btn-info">
        <span class="glyphicon glyphicon-plus"></span> <?php echo Yii::t('jonathan', 'Añadir convenio'); ?>
    </div><br><br>

    <?php $this->registerJs("
    $(document).ready(function() {
        var intercambios = $('.intercambios');
        var boton = $('.anyadir_intercambios');

        $(boton).click(function (e) {
            e.preventDefault();
            var num = document.getElementById('intercambios').childElementCount;
            $(intercambios).append(\"<tr>\"
              + \"<td><div class='form-group field-intercambios-\"+num+\"-nombre_entidad'>\"
              + \"  <div>\"
              + \"    <input id='intercambios-\"+num+\"-nombre_entidad' class='form-control' name='ConvenioIntercambios[\"+num+\"][nombre_entidad]' maxlength='250' type='text'>\"
              + \"    <p class='help-block help-block-error'></p>\"
              + \"  </div></div>\"
              + \"</td>\"
              + \"<td><div class='form-group field-ficheropdf-\"+num+\"-fichero'>\"
              + \"  <div>\"
              + \"    <input name='FicheroPdf[intercambios-\"+num+\"][fichero]' value='' type='hidden'>\"
              + \"    <input accept='.pdf' id='ficheropdf-intercambios-\"+num+\"-fichero' class='btn filestyle'\"
              + \"      name='FicheroPdf[intercambios-\"+num+\"][fichero]' type='file' data-buttonbefore='true' data-icon='false'\"
              + \"      data-buttonText='Seleccionar documento'>\"
              + \"    <p class='help-block'>Tamaño máximo: $max_filesize</p>\"
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

        $(intercambios).on('click', '.delete', function (e) {
            e.preventDefault();
            $(this).parent('td').parent('tr').remove();
        });
    });
    ");

    echo "<hr>\n";

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
