<?php

use app\models\Estado;
use app\models\Respuesta;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = $model->denominacion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuestas asignadas'), 'url' => ['evaluador/index']];
$this->params['breadcrumbs'][] = $this->title;

$asignacion = $model->getPropuestaEvaluadors()->delEvaluador(Yii::$app->user->id)->one();
?>

<?php
if ($asignacion->estado_id === Estado::VALORACION_PENDIENTE) {
    echo \yii\bootstrap\Alert::widget(
        [
            'body' => "<span class='glyphicon glyphicon-info-sign'></span>"
                . Yii::t('evaluador', 'En esta página puede comentar y puntuar cada uno de los apartados de la propuesta.') . ' '
                . Yii::t('evaluador', 'Puede modificar sus comentarios y puntuaciones tantas veces como desee.') . "<br>\n"
                . Yii::t('evaluador', 'Una vez esté satisfecho, pulse el botón «Presentar la valoración».') . "<br>\n",
            'options' => ['class' => 'alert-info'],
        ]
    );
}
?>

<h1><?php echo Html::encode($this->title); ?></h1>
<hr><br>

<?php
/* ⸻⸻⸻⸻⸻⸻⸻⸻ Datos identificativos de la propuesta ⸻⸻⸻⸻⸻⸻⸻⸻ */

echo '<h2>' . Yii::t('jonathan', '1. Datos identificativos del máster') . '</h2>' . PHP_EOL;

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


/*̣ ⸻⸻⸻⸻⸻⸻⸻⸻ Preguntas y respuestas de la propuesta ⸻⸻⸻⸻⸻⸻⸻⸻ */

$evaluacion_presentable = true;

foreach ($preguntas as $pregunta) {
    echo "<br>\n\n<h2>" . Html::encode($pregunta->titulo) . '</h2>' . PHP_EOL;
    // echo "<p class='pregunta'><strong>" . nl2br(Html::encode($pregunta->descripcion)) . '</strong></p>' . PHP_EOL;

    $respuesta = $respuestas[$pregunta->id];
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

    /* Valoración de las respuestas de cada pregunta */
    $bloques = $pregunta->bloques;
    foreach ($bloques as $bloque) {
        echo "<div class='cuadro-gris'>\n";
        $valoracion = $bloque->getValoracions()->deLaPropuesta($model->id)->delEvaluador(Yii::$app->user->id)->one();
        echo "<h3>{$bloque->titulo} ({$bloque->porcentaje}%)</h3>\n";
        echo "<p style='font-weight: bold;'>" . nl2br(Html::encode($bloque->descripcion)) . "</p>\n\n";

        printf("<h4>%s</h4>\n", Yii::t('evaluador', 'Comentarios'));
        if ($valoracion) {
            echo '<p>' . nl2br(Html::encode($valoracion->comentarios)) . '</p>' . PHP_EOL;
        } else {
            $evaluacion_presentable = false;
        }

        if (!$bloque->tiene_puntuacion_interna) {
            printf("<h4>%s</h4>\n", Yii::t('evaluador', 'Puntuación'));
            if ($valoracion) {
                echo '<p>' . Yii::$app->formatter->asDecimal($valoracion->puntuacion, 1) . "</p>\n\n";
                if ($valoracion->puntuacion === null) {  // 0 es falsey, pero es una puntuación válida.
                    $evaluacion_presentable = false;
                }
            }
        }

        if ($asignacion->estado_id === Estado::VALORACION_PENDIENTE) {
            echo Html::a(
                '<span class="glyphicon glyphicon-pencil"></span> &nbsp;' . Yii::t('jonathan', 'Editar'),
                $valoracion ? ['evaluador/valoracion/editar', 'id' => $valoracion->id]
                            : ['evaluador/valoracion/crear', 'bloque_id' => $bloque->id, 'respuesta_id' => $respuesta->id],
                ['id' => "editar-valoracion-{$bloque->id}", 'class' => 'btn btn-info']
            ) . "<br>\n";
        }
        echo "</div><br>\n";
    }
}

/* Valoración de los bloques independientes de preguntas */
foreach ($bloques_autonomos as $bloque) {
    echo "<div class='cuadro-gris'>\n";
    $valoracion = $bloque->getValoracions()->deLaPropuesta($model->id)->delEvaluador(Yii::$app->user->id)->one();
    echo "<h3>{$bloque->titulo}</h3>\n";
    echo "<p style='font-weight: bold;'>" . nl2br(Html::encode($bloque->descripcion)) . "</p>\n\n";

    printf("<h4>%s</h4>\n", Yii::t('evaluador', 'Comentarios'));
    if ($valoracion) {
        echo '<p>' . nl2br(Html::encode($valoracion->comentarios)) . '</p>' . PHP_EOL;
    }
    if (!$bloque->tiene_puntuacion_interna) {
        printf("<h4>%s</h4>\n", Yii::t('evaluador', 'Puntuación'));
        if ($valoracion) {
            echo '<p>' . Yii::$app->formatter->asDecimal($valoracion->puntuacion, 1) . "</p>\n\n";
        }
    }

    if ($asignacion->estado_id === Estado::VALORACION_PENDIENTE) {
        echo Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> &nbsp;' . Yii::t('jonathan', 'Editar'),
            $valoracion ? ['evaluador/valoracion/editar', 'id' => $valoracion->id]
                        : ['evaluador/valoracion/crear-autonoma', 'bloque_id' => $bloque->id, 'propuesta_id' => $model->id],
            ['id' => "editar-valoracion-{$bloque->id}", 'class' => 'btn btn-info']
        ) . "<br>\n";
    }
    echo "</div>\n";
}

echo "<hr><br>\n";

/* Cálculo de la puntuación final */
echo "<div class='cuadro-gris'>\n";
printf("<h4>%s</h4>\n", Yii::t('evaluador', 'Puntuación final'));

echo Yii::$app->formatter->asDecimal(
    array_sum(
        array_map(
            function ($valoracion) {
                return ($valoracion->bloque->porcentaje / 100) * $valoracion->puntuacion;
            },
            $valoraciones
        )
    ),
    2
);
echo "</div>\n<br>\n";

/* Presentación de la valoración */
if ($asignacion->estado_id === Estado::VALORACION_PENDIENTE) {
    echo Html::a(
        '<span class="glyphicon glyphicon-check"></span> &nbsp;' . Yii::t('jonathan', 'Presentar la valoración'),
        ['', '#' => 'modalPresentar'],
        [
            'id' => 'presentar',
            'class' => 'btn btn-danger',
            'disabled' => !$evaluacion_presentable,
            'data-toggle' => 'modal',
            'title' => Yii::t(
                'jonathan',
                "Presentar la valoración de la propuesta.\nYa no se podrán hacer más modificaciones."
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
                <h4 class="modal-title"><?php echo Yii::t('jonathan', '¿Presentar la valoración?'); ?></h4>
            </div>

            <div class="modal-body">
            <p><?php
            if ($evaluacion_presentable) {
                printf(
                    Yii::t(
                        'jonathan',
                        '¿Seguro que ha finalizado y desea presentar la valoración de la propuesta «%s»?<br>'
                        . 'Una vez la haya presentado ya no podrá modificarla.'
                    ),
                    $model->denominacion
                );
            } else {
                echo \yii\bootstrap\Alert::widget(
                    [
                    'body' => "<span class='glyphicon glyphicon-exclamation-sign'></span>"
                        . Yii::t('evaluador', 'No puede presentar la valoración en estos momentos.') . "<br>\n"
                        . Yii::t('evaluador', 'Por favor, verifique que ha puntuado todos los apartados.') . "<br>\n",
                    'options' => ['class' => 'alert-danger'],
                    ]
                );
            }?></p>
            </div>

            <div class="modal-footer">
                <?php
                if ($evaluacion_presentable) {
                    echo Html::a(
                        '<span class="glyphicon glyphicon-exclamation-sign"></span> &nbsp;'
                            . Yii::t('jonathan', 'Presentar la valoración'),
                        [
                            '//evaluador/propuesta-evaluador/presentar',
                            'id' => $asignacion->id,
                        ],
                        [
                            'id' => 'confirmar-presentacion',
                            'class' => 'btn btn-danger',  // Botón
                            'data-method' => 'post',
                            'title' => Yii::t('jonathan', 'La valoración está acabada. Presentarla.'),
                        ]
                    );
                }
                ?>

                <button type="button" class="btn btn-info" data-dismiss="modal">
                    <?php echo '<span class="glyphicon glyphicon-remove"></span> &nbsp;' . Yii::t('jonathan', 'Cancelar'); ?>
                </button>
            </div>
        </div>
    </div>
</div>
