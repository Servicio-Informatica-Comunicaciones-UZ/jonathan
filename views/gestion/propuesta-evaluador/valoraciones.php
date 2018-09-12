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

<div class='table-responsive'>
<?php
echo GridView::widget([
    'dataProvider' => $asignacionesDataProvider,
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
            'attribute' => 'user_id',
            'label' => Yii::t('jonathan', 'Evaluador'),
            'value' => function ($asignacion) {
                return $asignacion->user->profile->name;
            }
        ], [
            'attribute' => 'estado_id',
            'format' => 'html',
            'label' => Yii::t('jonathan', 'Estado'),
            'value' => function ($asignacion) {
                $estado = $asignacion->estado;

                if ($estado->id === Estado::VALORACION_PRESENTADA) {
                    return Html::a(
                        $estado->nombre,
                        [
                            '@web/gestion/valoracion/ver',
                            'user_id' => $asignacion->user_id,
                            'propuesta_id' => $asignacion->propuesta_id,
                        ]
                    );
                }
                return $estado->nombre;
            }
        ],
    ],
    'options' => ['class' => 'cabecera-azul'],
    // 'pager' => ...,
    'summary' => false,  // Do not show `Showing 1-19 of 19 items'.
    'tableOptions' => ['class' => 'table table-striped table-hover'],
]);
?>
</div>
