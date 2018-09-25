<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('jonathan', 'Asignaciones Propuesta⟷Evaluador');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gestión'), 'url' => ['//gestion/index']];
$this->params['breadcrumbs'][] = $this->title;

// Change background color
$this->registerCssFile('@web/css/gestion.css', ['depends' => 'app\assets\AppAsset']);
?>

<h1><?php echo Html::encode($this->title); ?></h1>
<hr><br>

<?php
echo \yii\bootstrap\Alert::widget([
    'body' => "<span class='glyphicon glyphicon-info-sign'></span>"
        . Yii::t('jonathan', 'Sólo se muestran las propuestas que hayan sido aprobadas internamente.'),
    'options' => ['class' => 'alert-info'],
]);

\yii\widgets\Pjax::begin([
    'id' => 'pjax-main',
    'enableReplaceState' => false,
    'linkSelector' => '#pjax-main ul.pagination a, th a',
    // 'clientOptions' => ['pjax:success' => 'function() { alert("yo"); }'],
]);
?>

<div class="table-responsive">
    <?php echo GridView::widget([
        'dataProvider' => $dpEvaluables,
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
            ], [
                'format' => 'html',
                'label' => Yii::t('jonathan', 'Evaluadores'),
                'value' => function ($propuesta) {
                    $nombres = ArrayHelper::getColumn($propuesta->evaluadores, 'profile.name');
                    $nombres = array_map('\yii\helpers\Html::encode', $nombres);

                    return $nombres ? '<ul class="listado"><li>' . implode("</li>\n<li>", $nombres) . '</li></ul>' : null;
                },
            ], [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'editar-evaluadores' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('gestion', 'Editar los evaluadores'),
                            'aria-label' => Yii::t('gestion', 'Editar los evaluadores'),
                            'data-pjax' => '0',
                        ];

                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                    },
                ],
                // 'controller' => 'gestion',
                'template' => '{editar-evaluadores}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    $params = [$action, 'id' => $model->id];

                    return Url::toRoute($params);
                },
                // visibleButtons => ...,
                'contentOptions' => ['nowrap' => 'nowrap'],
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
