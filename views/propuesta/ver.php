<?php

use app\models\Estado;
use app\models\Respuesta;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = $model->denominacion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuestas'), 'url' => ['listado']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?php echo Html::encode($this->title); ?></h1>

<hr><br>

<div class="container">

<?php
/* Datos identificativos de la propuesta */

echo '<h2>' . Yii::t('jonathan', 'Datos identificativos del máster') . '</h2>' . PHP_EOL;

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
        ],
        'denominacion',
        [
            'label' => Yii::t('jonathan', 'Macroárea(s)'),
            'value' => function ($model) {
                $macroareas = $model->propuestaMacroareas;
                $nombres = array_map(function ($m) {
                    return $m->macroarea->nombre;
                }, $macroareas);
                // $nombres = array_column(array_column($macroareas, 'macroarea'), 'nombre');

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
                        $salida .= "<li>{$centro->nombre_centro}";
                        if ($centro->documento_firma) {
                            $salida .= ' ['
                            . Html::a(
                                $centro->documento_firma,
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

                return $nombres ? "<ul class='listado'><li>" . implode('</li><li>', $nombres) . '</li></ul>' : null;
            },
            'format' => 'html',
        ], [
            'label' => Yii::t('jonathan', 'Programa de doctorado a los que podría dar acceso'),
            'value' => function ($model) {
                $nombres = array_column($model->propuestaDoctorados, 'nombre_doctorado');

                return $nombres ? "<ul class='listado'><li>" . implode('</li><li>', $nombres) . '</li></ul>' : null;
            },
            'format' => 'html',
        ], [
            'label' => Yii::t('jonathan', 'Grupos de investigación reconocidos por el Gobierno de Aragón que apoyan la propuesta'),
            'value' => function ($model) {
                $salida = null;
                $grupos = $model->propuestaGrupoInves;
                if ($grupos) {
                    $salida = "<ul class='listado'>\n";
                    foreach ($grupos as $grupo) {
                        $salida .= "<li>{$grupo->nombre_grupo_inves}";
                        if ($grupo->documento_firma) {
                            $salida .= ' ['
                            . Html::a(
                                $grupo->documento_firma,
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
        ]
    ],
]) . "\n\n";

if ($model->estado_id == Estado::BORRADOR) {
    echo Html::a(
        '<span class="glyphicon glyphicon-pencil"></span> &nbsp;' . Yii::t('jonathan', 'Editar'),
        ['editar', 'id' => $model->id],
        ['id' => 'editar', 'class' => 'btn btn-info']
    ) . "<br>\n\n";
}

/* Preguntas y respuestas de la propuesta */
foreach ($preguntas as $pregunta) {
    echo "<br>\n<h2>" . Html::encode($pregunta->titulo) . '</h2>' . PHP_EOL;
    echo '<p><strong>' . Html::encode($pregunta->descripcion) . '</strong></p>' . PHP_EOL;
    $respuestas = array_filter($model->respuestas, function ($r) use ($pregunta) {
        return $r->pregunta_id == $pregunta->id;
    });
    $respuesta= isset($respuestas[0]) ? $respuestas[0] : null;
    if (!$respuesta) {
        $respuesta = new Respuesta(['propuesta_id' => $model->id, 'pregunta_id' => $pregunta->id]);
        $respuesta->save();
    }
    echo '<p>' . nl2br(Html::encode($respuesta->valor)) . '</p>' . PHP_EOL;
    if ($model->estado_id == Estado::BORRADOR) {
        echo Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> &nbsp;' . Yii::t('jonathan', 'Editar'),
            ['respuesta/editar', 'id' => $respuesta->id],
            ['id' => "editar-{$respuesta->id}", 'class' => 'btn btn-info']
        ) . "<br>\n\n";
    }
}


echo "<hr><br>\n";
if ($model->estado_id == Estado::BORRADOR) {
    echo Html::a(
        '<span class="glyphicon glyphicon-check"></span> &nbsp;' . Yii::t('jonathan', 'Presentar la propuesta'),
        ['presentar', 'id' => $model->id],
        [
            'id' => 'presentar',
            'class' => 'btn btn-danger',
            'title' => Yii::t(
                'jonathan',
                "Presentar la propuesta para su evaluación.\nYa no se podrán hacer más modificaciones."
            ),
        ]
    ) . "\n";
}
?>

</div> <!-- container -->
