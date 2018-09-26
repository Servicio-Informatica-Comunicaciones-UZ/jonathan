<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Estado;

$this->title = Yii::t('jonathan', 'Valoraciones');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gestión'), 'url' => ['//gestion/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?php echo Html::encode($this->title); ?></h1>
<hr><br>

<?php
\yii\widgets\Pjax::begin([
    'id' => 'pjax-main',
    'enableReplaceState' => false,
    'linkSelector' => '#pjax-main ul.pagination a, th a',
    // 'clientOptions' => ['pjax:success' => 'function() { alert("yo"); }'],
]);
?>

<div class='table-responsive'>
<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    // 'caption' => '',
    'columns' => [
        [
            'attribute' => 'propuesta.denominacion',
            'format' => 'html',
            'value' => function ($asignacion) {
                return Html::a(
                    Html::encode(trim($asignacion->propuesta->denominacion)) ?:
                        '<span class="not-set">' . Yii::t('jonathan', '(no definido)') . '</span>',
                    ['//gestion/propuesta/ver', 'id' => $asignacion->propuesta_id]
                );
            },
        ], [
            'attribute' => 'nombreEvaluador',
        ], [
            'attribute' => 'estado_id',
            'filter' => Html::activeDropDownList(
                $searchModel,
                'estado_id',
                $mapa_estados,
                ['class' => 'form-control', 'prompt' => Yii::t('gestion', 'Todos')]
            ),
            'format' => 'html',
            'label' => Yii::t('jonathan', 'Estado'),
            'value' => function ($asignacion) {
                $estado = $asignacion->estado;

                if ($estado->id === Estado::VALORACION_PRESENTADA) {
                    return Html::a(
                        Yii::t('db', $estado->nombre),
                        [
                            '@web/gestion/valoracion/ver',
                            'user_id' => $asignacion->user_id,
                            'propuesta_id' => $asignacion->propuesta_id,
                        ]
                    );
                }
                return Yii::t('db', $estado->nombre);
            }
        ],
    ],
    'options' => ['class' => 'cabecera-azul'],
    // 'pager' => ...,
    'summary' => false,  // Do not show `Showing 1-19 of 19 items'.
    'tableOptions' => ['class' => 'table table-bordered table-hover table-striped'],
]);
?>
</div>

<?php
\yii\widgets\Pjax::end();
