<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = Yii::t('evaluador', 'Nueva evaluación');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuestas asignadas'), 'url' => ['evaluador/index']];
$this->params['breadcrumbs'][] = [
    'label' => $model->respuesta->propuesta->denominacion,
    'url' => ['//evaluador/propuesta/ver', 'propuesta_id' => $model->respuesta->propuesta_id],
];
$this->params['breadcrumbs'][] = $this->title;

// Change background color
$this->registerCssFile('@web/css/gestion.css', ['depends' => 'app\assets\AppAsset']);
?>


<h1><?php echo Html::encode($this->title); ?></h1>
<hr><br>

<h2><?php echo Html::encode($model->respuesta->pregunta->titulo);?></h2>
<p class='pregunta'><strong><?php echo nl2br(Html::encode($model->respuesta->pregunta->descripcion)); ?></strong></p>

<?php
echo '<div>' . str_replace(
    '<table>',
    "<table class='table table-bordered'>",
    HtmlPurifier::process(
        $model->respuesta->valor,
        [
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
        ]
    )
) . "</div>\n\n"; ?>

<div class='cuadro-gris'>
    <h3><?php echo "{$model->bloque->titulo} ({$model->bloque->porcentaje}%)"; ?></h3>
    <p style='font-weight: bold;'><?php echo nl2br(Html::encode($model->bloque->descripcion)); ?></p>

    <?php echo $this->render('_formulario', ['model' => $model]); ?>
</div>
