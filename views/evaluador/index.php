<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('jonathan', 'Propuestas asignadas para su valoración');
$this->params['breadcrumbs'][] = $this->title;
?>


<h1><?php echo Html::encode($this->title); ?></h1>
<hr><br>

<div class='table-responsive'>
<?php
echo GridView::widget([
    'dataProvider' => $asignadasDataProvider,
    // 'caption' => '',
    'columns' => [
        'anyo',
        [
            'attribute' => 'denominacion',
            'format' => 'html',
            'value' => function ($propuesta) {
                return Html::a(
                    Html::encode(trim($propuesta->denominacion)) ?:
                        '<span class="not-set">' . Yii::t('jonathan', '(no definido)') . '</span>',
                    ['//evaluador/propuesta/ver', 'propuesta_id' => $propuesta->id],
                    [
                        'title' => Yii::t('evaluador', 'Ver/valorar la propuesta'),
                        'aria-label' => Yii::t('evaluador', 'Ver/valorar la propuesta'),
                    ]
                );
            },
        ], [
            'attribute' => 'user.profile.name',
            'label' => Yii::t('jonathan', 'Responsable'),
        ], [
            'label' => Yii::t('jonathan', 'Estado'),
            'value' => function ($propuesta) {
                $asignacion = $propuesta->getPropuestaEvaluadors()->delEvaluador(Yii::$app->user->id)->one();
                return $asignacion->estado_id ? $asignacion->estado->nombre : null;
            }
        ], /* [
            'class' => yii\grid\ActionColumn::className(),  // 'yii\grid\ActionColumn',
            'template' => '{ver}',
            'buttons' => [
                'ver' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('evaluador', 'Ver/valorar la propuesta'),
                        'aria-label' => Yii::t('evaluador', 'Ver/valorar la propuesta'),
                        'data-pjax' => '0',
                    ];

                    return Html::a(
                        '<span class="glyphicon glyphicon glyphicon-eye-open" aria-label="Ver"></span>',
                        $url,
                        $options
                    );
                },
            ],
            'controller' => 'evaluador/propuesta',
            'urlCreator' => function ($action, $model, $key, $index, $actionColumn) {
                return Url::toRoute([
                    $actionColumn->controller ? $actionColumn->controller . '/' . $action : $action,
                    'propuesta_id' => $key,
                ]);
            },
        ], */
        [
            'format' => 'html',
            'value' => function ($propuesta) {
                return Html::a(
                    '<span class="glyphicon glyphicon glyphicon-save-file" aria-label="Ver"></span>',
                    "@web/pdf/propuestas/{$propuesta->id}-fase{$propuesta->fase}.pdf",
                    [
                        'title' => Yii::t('evaluador', 'Descargar PDF de la propuesta'),
                        'aria-label' => Yii::t('evaluador', 'Descargar PDF de la propuesta'),
                    ]
                );
            },
        ]
    ],
    'options' => ['class' => 'cabecera-azul'],
    // 'pager' => ...,
    'summary' => false,  // Do not show `Showing 1-19 of 19 items'.
    'tableOptions' => ['class' => 'table table-striped table-hover'],
]);
?>
</div>
