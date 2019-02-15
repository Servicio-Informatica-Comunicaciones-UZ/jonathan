<?php

use app\models\Estado;
use app\models\Respuesta;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = $model->denominacion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuestas'), 'url' => ['listado']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?php echo Html::encode($this->title); ?></h1>

<hr><br>

<?php
/* Datos identificativos de la propuesta */

echo '<h2>' . Yii::t('jonathan', 'Datos identificativos del máster') . '</h2>' . PHP_EOL;

echo DetailView::widget(
    [
        'model' => $model,
        'attributes' => [
            // 'id',
            // 'anyo',
            [
                'label' => Yii::t('jonathan', 'Usuario responsable'),
                'attribute' => 'user.username',
            ], [
                'label' => Yii::t('jonathan', 'Nombre del responsable'),
                'attribute' => 'user.profile.name',
            ], [
                'label' => Yii::t('jonathan', 'Correo del responsable'),
                'attribute' => 'user.email',
            ], [
                'attribute' => 'denominacion',
                'value' => function ($model) {
                    return trim($model->denominacion) ?: null;
                },
            ], [
                'label' => Yii::t('jonathan', 'Macroárea(s)'),
                'value' => function ($model) {
                    $nombres = \yii\helpers\ArrayHelper::getColumn($model->propuestaMacroareas, 'macroarea.nombre');
                    $nombres = array_map('\yii\helpers\Html::encode', $nombres);

                    return $nombres ? '<ul class="listado"><li>' . implode('</li><li>', $nombres) . '</li></ul>' : null;
                },
                'format' => 'html',
            ], [
                'label' => Yii::t('jonathan', 'Centro(s)'),
                'value' => function ($model) {
                    $centros = $model->propuestaCentros;

                    $salida = null;
                    if ($centros) {
                        $salida = "<ul class='listado'>\n";
                        foreach ($centros as $centro) {
                            $salida .= '<li>' . Html::encode($centro->nombre_centro);
                            if ($centro->documento_firma) {
                                $salida .= ' ['
                                . Html::a(
                                    Html::encode($centro->documento_firma),
                                    Url::home() . "pdf/firmas_centros/{$centro->id}.pdf"
                                ) . ']';
                            }
                            $salida .= "</li>\n";
                        }
                        $salida .= "</ul>\n";
                    }

                    return $salida;
                },
                'format' => 'html',
            ], [
                'label' => Yii::t('jonathan', 'Orientación'),
                'attribute' => 'orientacion.nombre',
            ],
            'creditos',
            'duracion',
            [
                'label' => Yii::t('jonathan', 'Modalidad de impartición'),
                'attribute' => 'modalidad.nombre',
            ],
            'plazas',
            'creditos_practicas',
            [
                'label' => Yii::t('jonathan', 'Titulaciones a las que va dirigido'),
                'value' => function ($model) {
                    $nombres = array_column($model->propuestaTitulacions, 'nombre_titulacion');
                    $nombres = array_map('\yii\helpers\Html::encode', $nombres);

                    return $nombres ? "<ul class='listado'><li>" . implode('</li><li>', $nombres) . '</li></ul>' : null;
                },
                'format' => 'html',
            ], [
                'attribute' => 'memoria_verificacion',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->memoria_verificacion) {
                        return Html::a(
                            Html::encode($model->memoria_verificacion),
                            "@web/pdf/memorias_verificacion/{$model->id}.pdf"
                        );
                    }
                }
            ], [
                'attribute' => 'memoria_economica',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->memoria_economica) {
                        return Html::a(
                            Html::encode($model->memoria_economica),
                            "@web/pdf/memorias_economicas/{$model->id}.pdf"
                        );
                    }
                }
            ], [
                'label' => 'Estado de la propuesta',
                'attribute' => 'estado.nombre',
            ],
        ],
    ]
) . "\n\n";

if (Estado::APROB_EXTERNA === $model->estado_id && $model->user_id === Yii::$app->user->id) {
    echo Html::a(
        '<span class="glyphicon glyphicon-pencil"></span> &nbsp;' . Yii::t('jonathan', 'Editar'),
        ['editar', 'id' => $model->id],
        ['id' => 'editar', 'class' => 'btn btn-info']
    ) . "<br>\n\n";
}

/* Preguntas y respuestas de la propuesta */
foreach ($preguntas as $pregunta) {
    echo "<br>\n<h2>" . HtmlPurifier::process($pregunta->titulo) . '</h2>' . PHP_EOL;
    // echo "<p class='pregunta'><strong>" . HtmlPurifier::process($pregunta->descripcion) . '</strong></p>' . PHP_EOL;
    $respuestas = array_filter(
        $model->respuestas,
        function ($r) use ($pregunta) {
            return $r->pregunta_id == $pregunta->id;
        }
    );
    $respuesta = reset($respuestas);  // Returns the value of the first array element, or FALSE if the array is empty.
    if (!$respuesta) {
        $respuesta = new Respuesta(['propuesta_id' => $model->id, 'pregunta_id' => $pregunta->id]);
        $respuesta->save();
    }

    echo '<div>' . str_replace(
        '<table>',
        "<table class='table table-bordered'>",
        HtmlPurifier::process(
            $respuesta->valor,
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
    ) . "</div>\n\n";
    if ($model->estado_id === Estado::APROB_EXTERNA && $model->user_id === Yii::$app->user->id) {
        echo Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> &nbsp;' . Yii::t('jonathan', 'Editar'),
            ['respuesta/editar', 'id' => $respuesta->id],
            ['id' => "editar-{$respuesta->id}", 'class' => 'btn btn-info']
        ) . "<br>\n\n";
    }
}

echo "<hr><br>\n";
if ($model->estado_id === Estado::APROB_EXTERNA && $model->user_id === Yii::$app->user->id) {
    echo Html::a(
        '<span class="glyphicon glyphicon-check"></span> &nbsp;' . Yii::t('jonathan', 'Presentar la propuesta'),
        ['', '#' => 'modalPresentar'],
        [
            'id' => 'presentar',
            'class' => 'btn btn-danger',
            'data-toggle' => 'modal',
            'title' => Yii::t(
                'jonathan',
                "Presentar la propuesta para su evaluación.\nYa no se podrán hacer más modificaciones."
            ),
        ]
    ) . "\n";
}
?>

<!-- Diálogo modal -->
<div id="modalPresentar" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo Yii::t('jonathan', '¿Presentar la propuesta?'); ?></h4>
            </div>

            <div class="modal-body">
                <p><?php printf(
                    Yii::t(
                        'jonathan',
                        '¿Seguro que ha finalizado y desea presentar la propuesta de «%s»?<br>'
                        . 'Una vez la haya presentado ya no podrá modificarla.'
                    ),
                    $model->denominacion
                ); ?></p>
            </div>

            <div class="modal-footer">
                <?php
                echo Html::a(
                    '<span class="glyphicon glyphicon-exclamation-sign"></span> &nbsp;'
                        . Yii::t('jonathan', 'Presentar la propuesta'),
                    [
                        'presentar',
                        'id' => $model->id,
                    ],
                    [
                        'id' => 'confirmar-presentacion',
                        'class' => 'btn btn-danger',  // Botón
                        'title' => Yii::t('jonathan', 'La propuesta está acabada. Presentarla.'),
                    ]
                );
                ?>

                <button type="button" class="btn btn-info" data-dismiss="modal">
                    <?php echo '<span class="glyphicon glyphicon-remove"></span> &nbsp;' . Yii::t('jonathan', 'Cancelar'); ?>
                </button>
            </div>
        </div>
    </div>
</div>
