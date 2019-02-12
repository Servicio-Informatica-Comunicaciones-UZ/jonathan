<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use marqu3s\summernote\Summernote;

$this->title = Yii::t('jonathan', 'Editar respuesta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuestas'), 'url' => ['propuesta/listado']];
$this->params['breadcrumbs'][] = [
    'label' => $model->propuesta->denominacion,
    'url' => ['propuesta/ver', 'id' => $model->propuesta_id],
];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>
    <?php echo Html::encode($this->title); ?>
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

    echo "<div class='form-group'>";
    printf(
        "<label class='control-label' for='respuesta-valor'><h2>%s</h2></label>",
        HtmlPurifier::process($model->pregunta->titulo)
    );
    echo Summernote::widget([
        'id' => 'respuesta-valor',
        'name' => 'Respuesta[valor]',
        'value' => ($model and $model->valor) ?
            HtmlPurifier::process($model->valor, [
                'Attr.ForbiddenClasses' => ['Apple-interchange-newline', 'Apple-converted-space',
                    'Apple-paste-as-quotation', 'Apple-style-span', 'Apple-tab-span', 'BalloonTextChar', 'BodyTextIndentChar',
                    'Heading1Char', 'Heading2Char', 'Heading3Char', 'Heading4Char', 'Heading5Char', 'Heading6Char',
                    'IntenseQuoteChar', 'MsoAcetate', 'MsoBodyText', 'MsoBodyText1', 'MsoBodyText2', 'MsoBodyText3',
                    'MsoBodyTextIndent', 'MsoBookTitle', 'MsoCaption', 'MsoChpDefault',
                    'MsoFooter', 'MsoHeader', 'MsoHyperlink', 'MsoHyperlinkFollowed',
                    'MsoIntenseEmphasis', 'MsoIntenseQuote', 'MsoIntenseReference', 'MsoListParagraph',
                    'MsoListParagraphCxSpFirst', 'MsoListParagraphCxSpMiddle', 'MsoListParagraphCxSpLast',
                    'MsoNormal', 'MsoNormalTable', 'MsoNoSpacing', 'MsoPapDefault', 'MsoQuote',
                    'MsoSubtleEmphasis', 'MsoSubtleReference', 'MsoTableGrid',
                    'MsoTitle', 'MsoTitleCxSpFirst', 'MsoTitleCxSpMiddle', 'MsoTitleCxSpLast',
                    'MsoToc1', 'MsoToc2', 'MsoToc3', 'MsoToc4', 'MsoToc5', 'MsoToc6', 'MsoToc7', 'MsoToc8', 'MsoToc9',
                    'MsoTocHeading', 'QuoteChar', 'SubtitleChar', 'TitleChar',
                    'western', 'WordSection1', ],
                'CSS.ForbiddenProperties' => ['background', 'border', 'border-bottom',
                    'border-collapse', 'border-left', 'border-right', 'border-style', 'border-top', 'border-width',
                    'font', 'font-family', 'font-size', 'font-weight', 'height', 'line-height',
                    'margin', 'margin-bottom', 'margin-left', 'margin-right', 'margin-top',
                    'padding', 'padding-bottom', 'padding-left', 'padding-right', 'padding-top',
                    'text-autospace', 'text-indent', 'width', ],
                'HTML.ForbiddenAttributes' => ['align', 'background', 'bgcolor', 'border',
                    'cellpadding', 'cellspacing', 'height', 'hspace', 'noshade', 'nowrap',
                    'rules', 'size', 'valign', 'vspace', 'width', ],
                'HTML.ForbiddenElements' => ['font'],
                // 'data' permite incrustar imágenes en base64
                'URI.AllowedSchemes' => ['data' => true, 'http' => true, 'https' => true, 'mailto' => true],
            ])
            : '',
        'clientOptions' => [
            'lang' => 'es',
            'placeholder' => Yii::t('jonathan', 'Introduzca sus comentarios'),
        ],
    ]) . "\n\n";
    printf("<p class='help-block'>%s</p>\n", HtmlPurifier::process($model->pregunta->descripcion));
    echo "</div>\n";

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
