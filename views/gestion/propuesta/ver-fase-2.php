<?php

use app\models\Estado;
use app\models\Respuesta;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = $model->denominacion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gestión'), 'url' => ['//gestion/index']];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('jonathan', 'Propuestas'),
    'url' => Url::previous('listado'),
];
$this->params['breadcrumbs'][] = $this->title;

// Change background color
$this->registerCssFile('@web/css/gestion.css', ['depends' => 'app\assets\AppAsset']);
?>

<?php
if (Estado::PRESENTADA == $model->estado_id) {
    echo \yii\bootstrap\Alert::widget(
        [
        'body' => "<span class='glyphicon glyphicon-info-sign'></span>"
            . Yii::t('gestion', 'Esta página muestra una propuesta presentada.  Aquí puede:') . "<br>\n"
            . "<ul style='margin-left: 20px;'>\n<li>"
            . Yii::t('gestion', 'Rechazar la propuesta, si ésta carece de interés y no merece ser evaluada.') . ' '
            . Yii::t('gestion', 'Las propuestas desestimadas quedan archivadas.') . "</li>\n<li>"
            . Yii::t('gestion', 'Devolver la propuesta al proponente, si ésta tiene defectos que pueden ser subsanados.') . ' '
            . Yii::t('gestion', 'El proponente podrá hacer correcciones y volver a presentarla.') . "</li>\n<li>"
            . Yii::t('gestion', 'Aprobar la propuesta para que sea valorada externamente.') . "</li>\n</ul>\n\n",
        'options' => ['class' => 'alert-info'],
        ]
    );
}
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
                'label' => Yii::t('jonathan', 'Prácticas externas'),
                'value' => function ($model) {
                    $convenios = $model->convenioPracticas;

                    $salida = null;
                    if ($convenios) {
                        $salida = "<ul class='listado'>\n";
                        foreach ($convenios as $convenio) {
                            $salida .= '<li>' . Html::encode($convenio->nombre_entidad);
                            if ($convenio->documento) {
                                $salida .= ' ['
                                . Html::a(
                                    Html::encode($convenio->documento),
                                    "@web/pdf/convenios_practicas/{$convenio->id}.pdf"
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
                'label' => Yii::t('jonathan', 'Intercambios internacionales'),
                'value' => function ($model) {
                    $convenios = $model->convenioIntercambios;

                    $salida = null;
                    if ($convenios) {
                        $salida = "<ul class='listado'>\n";
                        foreach ($convenios as $convenio) {
                            $salida .= '<li>' . Html::encode($convenio->nombre_entidad);
                            if ($convenio->documento) {
                                $salida .= ' ['
                                . Html::a(
                                    Html::encode($convenio->documento),
                                    "@web/pdf/convenios_intercambios/{$convenio->id}.pdf"
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
                'label' => 'Estado de la propuesta',
                'attribute' => 'estado.nombre',
            ],
        ],
    ]
) . "\n\n";


/* Preguntas y respuestas de la propuesta */
foreach ($preguntas as $pregunta) {
    echo "<br>\n<h2>" . HtmlPurifier::process($pregunta->titulo) . '</h2>' . PHP_EOL;
    echo "<p class='pregunta'><strong>" . HtmlPurifier::process($pregunta->descripcion) . '</strong></p>' . PHP_EOL;
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
}

echo "<hr><br>\n";
if (Estado::PRESENTADA_FASE_2 === $model->estado_id) {
    echo Html::a(
        '<span class="glyphicon glyphicon-step-backward"></span> &nbsp;' . Yii::t('jonathan', 'Devolver al proponente'),
        ['devolver', 'id' => $model->id],
        [
            'id' => 'devolver',
            'class' => 'btn btn-warning',
            'data-confirm' => Yii::t('gestion', '¿Seguro que desea devolver esta propuesta al proponente?') . "\n\n"
                . Yii::t('gestion', 'El proponente podrá hacer modificaciones y volver a presentarla.'),
            'data-method' => 'post',
            'title' => Yii::t(
                'jonathan',
                "La propuesta requiere correcciones.\nVolverla a poner en el estado anterior a la presentación."
            ),
        ]
    ) . "&nbsp;\n&nbsp;";
}
