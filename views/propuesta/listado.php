<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = Yii::t('models', 'Propuestas realizadas');
$this->params['breadcrumbs'][] = $this->title;
?>


<h1>
    <?php echo Html::encode($this->title); ?>
    <small>
        <?php echo Html::encode(Yii::$app->user->identity->profile->name); ?>
    </small>
</h1>
<hr><br>

<?php
\yii\widgets\Pjax::begin([
    'id' => 'pjax-main',
    'enableReplaceState' => false,
    'linkSelector' => '#pjax-main ul.pagination a, th a',
    // 'clientOptions' => ['pjax:success' => 'function() { alert("yo"); }'],
]);
?>

<div class="table-responsive">
    <?php echo GridView::widget([
        'dataProvider' => $dpPropuestas,
        'columns' => [
            'anyo',
            [
                'attribute' => 'denominacion',
                'format' => 'html',
                'value' => function ($propuesta) {
                    return Html::a(
                        Html::encode(trim($propuesta->denominacion)) ?:
                            '<span class="not-set">' . Yii::t('jonathan', '(no definido)') . '</span>',
                        ['ver', 'id' => $propuesta->id]
                    );
                },
            ], [
                'label' => Yii::t('jonathan', 'Centro gestor'),
                'value' => function ($propuesta) {
                    // Se considera centro gestor al primero de la lista.
                    $centro_gestor = $propuesta->getPropuestaCentros()->orderBy(['id' => SORT_ASC])->limit(1)->one();

                    return $centro_gestor ? $centro_gestor->nombre_centro : null;
                },
            ], [
                'attribute' => 'estado.nombre',
                'label' => Yii::t('jonathan', 'Estado'),
            ],
        ],
        // 'caption' => '',
        'options' => ['class' => 'cabecera-azul'],
        'summary' => false,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
    ]); ?>
</div>

<?php
\yii\widgets\Pjax::end();

echo Html::a(
    '<span class="glyphicon glyphicon-plus"></span> &nbsp;' . Yii::t('jonathan', 'Nueva propuesta'),
    ['crear'],
    [
        'id' => 'crear',
        'class' => 'btn btn-info',
        'title' => Yii::t('jonathan', 'Crear una nueva propuesta'),
    ]
) . "\n";
