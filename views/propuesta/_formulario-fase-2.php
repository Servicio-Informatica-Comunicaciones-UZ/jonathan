<?php
use app\models\Estado;
use app\models\FicheroPdf;
use app\models\Macroarea;
use app\models\PropuestaCentro;
use app\models\PropuestaGrupoInves;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

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

    // Memoria de verificación
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

    // Memoria económica
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
