<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\Estado;

$titulos = [
    Estado::BORRADOR => Yii::t('jonathan', 'Propuestas en borrador'),
    Estado::PRESENTADA => Yii::t('jonathan', 'Propuestas presentadas pendientes de aprobación interna'),
    Estado::FUERA_DE_PLAZO => Yii::t('jonathan', 'Propuestas fuera de plazo'),
    Estado::APROB_INTERNA => Yii::t('jonathan', 'Propuestas aprobadas internamente'),
    Estado::RECHAZ_INTERNO => Yii::t('jonathan', 'Propuestas rechazadas internamente'),
    Estado::APROB_EXTERNA => Yii::t('jonathan', 'Propuestas aprobadas externamente'),
    Estado::RECHAZ_EXTERNO => Yii::t('jonathan', 'Propuestas rechazadas externamente'),
];

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gestión'), 'url' => ['//gestion/index']];
$this->params['breadcrumbs'][] = $this->title;

// Cambiar color de fondo
$this->registerCssFile('@web/css/gestion.css', ['depends' => 'app\assets\AppAsset']);
?>

<?php
\yii\widgets\Pjax::begin([
    'id' => 'pjax-main',
    'enableReplaceState' => false,
    'linkSelector' => '#pjax-main ul.pagination a, th a',
    // 'clientOptions' => ['pjax:success' => 'function() { alert("yo"); }'],
]);

$estado_id = ArrayHelper::getValue(Yii::$app->request->get('PropuestaSearch'), 'estado_id');
$this->title = ArrayHelper::getValue($titulos, $estado_id, Yii::t('jonathan', 'Todas las propuestas'));
?>

<h1><?php echo Html::encode($this->title); ?></h1>
<hr><br>

<div class="table-responsive">
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'denominacion',
                'format' => 'html',
                'value' => function ($propuesta) {
                    return Html::a(
                        Html::encode(trim($propuesta->denominacion)) ?:
                            '<span class="not-set">' . Yii::t('jonathan', '(no definido)') . '</span>',
                        ['//gestion/propuesta/ver', 'id' => $propuesta->id]
                    );
                },
            ],
            'nombreProponente',
            [
                'label' => Yii::t('jonathan', 'Centro gestor'),
                'value' => function ($propuesta) {
                    // Se considera centro gestor al primero de la lista.
                    $centro_gestor = $propuesta->getPropuestaCentros()->orderBy(['id' => SORT_ASC])->limit(1)->one();

                    return $centro_gestor ? $centro_gestor->nombre_centro : null;
                },
            ], [
                'attribute' => 'estado_id',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'estado_id',
                    $mapa_estados,
                    ['class' => 'form-control', 'prompt' => Yii::t('gestion', 'Todos')]
                ),
                'label' => Yii::t('jonathan', 'Estado'),
                'value' => function ($propuesta) {
                    return Yii::t('db', $propuesta->estado->nombre);
                }
            ],
        ],
        // 'caption' => '',
        'options' => ['class' => 'cabecera-azul'],
        'summary' => false,
        'tableOptions' => ['class' => 'table table-bordered table-striped table-hover'],
    ]); ?>
</div>

<?php
\yii\widgets\Pjax::end();
