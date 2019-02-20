<?php

use app\models\Estado;
use app\models\Respuesta;
use yii\helpers\Html;
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
                'label' => Yii::t('jonathan', 'Programa de doctorado a los que podría dar acceso'),
                'value' => function ($model) {
                    $nombres = array_column($model->propuestaDoctorados, 'nombre_doctorado');
                    $nombres = array_map('\yii\helpers\Html::encode', $nombres);

                    return $nombres ? "<ul class='listado'><li>" . implode('</li><li>', $nombres) . '</li></ul>' : null;
                },
                'format' => 'html',
            ], [
                'label' => Yii::t(
                    'jonathan',
                    'Grupos de investigación reconocidos por el Gobierno de Aragón' .
                    ' que apoyan la propuesta'
                ),
                'value' => function ($model) {
                    $salida = null;
                    $grupos = $model->propuestaGrupoInves;
                    if ($grupos) {
                        $salida = "<ul class='listado'>\n";
                        foreach ($grupos as $grupo) {
                            $salida .= '<li>' . Html::encode($grupo->nombre_grupo_inves);
                            if ($grupo->documento_firma) {
                                $salida .= ' ['
                                . Html::a(
                                    Html::encode($grupo->documento_firma),
                                    Url::home() . "pdf/firmas_grupos_inves/{$grupo->id}.pdf"
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
    echo "<br>\n<h2>" . Html::encode($pregunta->titulo) . '</h2>' . PHP_EOL;
    echo '<p><strong>' . Html::encode($pregunta->descripcion) . '</strong></p>' . PHP_EOL;
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
    echo '<p>' . nl2br(Html::encode($respuesta->valor)) . '</p>' . PHP_EOL;
}

echo "<hr><br>\n";
if (Estado::PRESENTADA == $model->estado_id) {
    echo Html::a(
        '<span class="glyphicon glyphicon-remove"></span> &nbsp;' . Yii::t('jonathan', 'Rechazar internamente'),
        ['rechazar', 'id' => $model->id],
        [
            'id' => 'rechazar',
            'class' => 'btn btn-danger',
            'data-confirm' => Yii::t('gestion', '¿Seguro que desea desestimar esta propuesta?') . "\n\n"
                . Yii::t('gestion', 'La propuesta quedará archivada pasa su consulta.'),
            'data-method' => 'post',
            'title' => Yii::t(
                'jonathan',
                "Desestimar la propuesta.\nLa propuesta quedará archivada para su consulta."
            ),
        ]
    ) . "&nbsp;\n&nbsp;";

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
                "La propuesta no cumple los requisitos.\nVolverla a poner en estado borrador para su corrección."
            ),
        ]
    ) . "&nbsp;\n&nbsp;";

    echo Html::a(
        '<span class="glyphicon glyphicon-ok"></span> &nbsp;' . Yii::t('jonathan', 'Aprobar internamente'),
        ['aprobacion-interna', 'id' => $model->id],
        [
            'id' => 'aprobar',
            'class' => 'btn btn-success',
            'data-confirm' => Yii::t('gestion', '¿Seguro que desea aprobar esta propuesta?'),
            'data-method' => 'post',
            'title' => Yii::t(
                'jonathan',
                "La propuesta cumple los criterios.\nAprobarla para su evaluación externa."
            ),
        ]
    ) . "\n";
}
