<?php

use app\models\Estado;
use app\models\Respuesta;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = $model->denominacion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuestas asignadas'), 'url' => ['evaluador/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?php echo Html::encode($this->title); ?></h1>

<hr><br>

<?php
/* ⸻⸻⸻⸻⸻⸻⸻⸻ Datos identificativos de la propuesta ⸻⸻⸻⸻⸻⸻⸻⸻ */

echo '<h2>' . Yii::t('jonathan', '1. Datos identificativos del máster') . '</h2>' . PHP_EOL;

echo DetailView::widget([
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
            }
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
            'label' => Yii::t('jonathan', 'Grupos de investigación reconocidos por el Gobierno de Aragón' .
                ' que apoyan la propuesta'),
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
]) . "\n\n";


/*̣ ⸻⸻⸻⸻⸻⸻⸻⸻ Preguntas y respuestas de la propuesta ⸻⸻⸻⸻⸻⸻⸻⸻ */

foreach ($preguntas as $pregunta) {
    echo "<br>\n<h2>" . Html::encode($pregunta->titulo) . '</h2>' . PHP_EOL;
    echo "<p class='pregunta'><strong>" . Html::encode($pregunta->descripcion) . '</strong></p>' . PHP_EOL;

    $respuesta = $respuestas[$pregunta->id];
    echo '<p>' . nl2br(Html::encode($respuesta->valor)) . '</p>' . PHP_EOL;

    $bloques = $pregunta->bloques;
    echo "<div style='background-color: #e9e9ee; border-radius: 3rem; padding: 0.1rem 2rem 2rem 3rem;'>";
    foreach ($bloques as $bloque) {
        $valoracion = $bloque->getValoracions()->one();  // FIXME Sólo las de este valorador
        echo "<h3>{$bloque->titulo}</h3>\n";
        echo "<p style='font-weight: bold;'>" . nl2br(Html::encode($bloque->descripcion)) . '</p>' . PHP_EOL;

        printf("<h4>%s</h4>\n", Yii::t('evaluador', 'Comentarios'));
        if ($valoracion) {
            echo '<p>' . nl2br(Html::encode($valoracion->comentarios)) . '</p>' . PHP_EOL;
        }
        printf("<h4>%s</h4>\n", Yii::t('evaluador', 'Puntuación'));
        if ($valoracion) {
            echo '<p>' . Yii::$app->formatter->asDecimal($valoracion->puntuacion, 1) . '</p>' . PHP_EOL;
        }
    }
    if (Estado::APROB_INTERNA == $model->estado_id) {
        echo Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> &nbsp;' . Yii::t('jonathan', 'Editar'),
            $valoracion ? ['evaluador/valoracion/editar', 'id' => $valoracion->id]
                        : ['evaluador/valoracion/crear', 'bloque_id' => $bloque->id, 'respuesta_id' => $respuesta->id],
            ['id' => "editar-valoracion-{$bloque->id}", 'class' => 'btn btn-info']
        ) . "<br>\n\n";
    }
    echo "</div>\n";
}

echo "<hr><br>\n";
if (Estado::BORRADOR == $model->estado_id) {
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
