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
echo '<h2>' . Yii::t('jonathan', 'Datos identificativos del máster') . '</h2>';

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

                return '<ul><li>' . implode('</li><li>', $nombres) . '</li></ul>';
            },
            'format' => 'html',
        ], [
            'label' => Yii::t('jonathan', 'Centro(s)'),
            'value' => function ($model) {
                $centros = $model->propuestaCentros;
                $nombres = array_column($centros, 'nombre_centro');

                return '<ul><li>' . implode('</li><li>', $nombres) . '</li></ul>';
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

                return '<ul><li>' . implode('</li><li>', $nombres) . '</li></ul>';
            },
            'format' => 'html',
        ], [
            'label' => Yii::t('jonathan', 'Programa de doctorado a los que podría dar acceso'),
            'value' => function ($model) {
                $nombres = array_column($model->propuestaDoctorados, 'nombre_doctorado');

                return '<ul><li>' . implode('</li><li>', $nombres) . '</li></ul>';
            },
            'format' => 'html',
        ], [
            'label' => Yii::t('jonathan', 'Grupos de investigación reconocidos por el Gobierno de Aragón que apoyan la propuesta'),
            'value' => function ($model) {
                $nombres = array_column($model->propuestaGrupoInves, 'nombre_grupo_inves');

                return '<ul><li>' . implode('</li><li>', $nombres) . '</li></ul>';
            },
            'format' => 'html',
        ],
    ],
]);

foreach ($model->respuestas as $respuesta) {
    echo '<br><h2>' . Html::encode($respuesta->pregunta->titulo) . '</h2>';
    echo '<p>' . Html::encode($respuesta->valor) . '</p>';
}
?>
</div> <!-- container -->