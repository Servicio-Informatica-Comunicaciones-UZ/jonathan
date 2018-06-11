<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('jonathan', 'Asignaciones Propuesta⟷Evaluador');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gestión'), 'url' => ['//gestion/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?php echo $this->title; ?></h1>
<hr><br>

<div class="table-responsive">
    <?php echo GridView::widget([
        'dataProvider' => $dpEvaluables,
        'columns' => [
            [
                'attribute' => 'denominacion',
                'format' => 'html',
                'value' => function ($propuesta) {
                    return Html::a(
                        trim($propuesta->denominacion) ?: '<em>'.Yii::t('jonathan', '(no definido)').'</em>',
                        ['//gestion/propuesta/ver', 'id' => $propuesta->id]
                    );
                },
            ], [
                'label' => Yii::t('jonathan', 'Evaluadores'),
                'value' => function ($propuesta) {
                    return implode(', ', array_column($propuesta->evaluadores, 'username'));  // profile.name
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
        'tableOptions' => ['class' => 'table table-striped table-hover'],
    ]); ?>
</div>