<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = $model->denominacion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuestas'), 'url' => ['index']];
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
        // 'nip',
        'denominacion',
        [
            'label' => Yii::t('jonathan', 'Macroárea(s)'),
            'value' => function ($model) {
                $macroareas = $model->propuestaMacroareas;
                $nombres = array_map(function ($m) {
                    return $m->macroarea->nombre;
                }, $macroareas);
                // $nombres = array_column(array_column($macroareas, 'macroarea'), 'nombre');

                return $nombres ? '<ul><li>' . implode('</li><li>', $nombres) . '</li></ul>' : null;
            },
            'format' => 'html',
        ], [
            'label' => Yii::t('jonathan', 'Centro(s)'),
            'value' => function ($model) {
                $centros = $model->propuestaCentros;
                $nombres = array_column($centros, 'nombre_centro');

                return $nombres ? '<ul><li>' . implode('</li><li>', $nombres) . '</li></ul>' : null;
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

                return $nombres ? '<ul><li>' . implode('</li><li>', $nombres) . '</li></ul>' : null;
            },
            'format' => 'html',
        ], [
            'label' => Yii::t('jonathan', 'Programa de doctorado a los que podría dar acceso'),
            'value' => function ($model) {
                $nombres = array_column($model->propuestaDoctorados, 'nombre_doctorado');

                return $nombres ? '<ul><li>' . implode('</li><li>', $nombres) . '</li></ul>' : null;
            },
            'format' => 'html',
        ], [
            'label' => Yii::t('jonathan', 'Grupos de investigación reconocidos por el Gobierno de Aragón que apoyan la propuesta'),
            'value' => function ($model) {
                $nombres = array_column($model->propuestaGrupoInves, 'nombre_grupo_inves');

                return $nombres ? '<ul><li>' . implode('</li><li>', $nombres) . '</li></ul>' : null;
            },
            'format' => 'html',
        ],
    ],
]) . "\n\n";

echo Html::a(
    '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('jonathan', 'Editar'),
    ['editar', 'id' => $model->id],
    ['id' => 'editar', 'class' => 'btn btn-info']
) . " &nbsp; \n\n";


/* Preguntas de la propuesta */

foreach ($model->respuestas as $respuesta) {
    echo "<br>\n<h2>" . Html::encode($respuesta->pregunta->titulo) . '</h2>' . PHP_EOL;
    echo '<p><strong>' . Html::encode($respuesta->pregunta->descripcion) . '</strong></p>' . PHP_EOL;
    echo '<p>' . Html::encode($respuesta->valor) . '</p>' . PHP_EOL;
    echo Html::a(
        '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('jonathan', 'Editar'),
        ['respuesta/editar', 'id' => $respuesta->id],
        ['id' => 'editar', 'class' => 'btn btn-info']
    ) . PHP_EOL . PHP_EOL;
}
?>
</div> <!-- container -->