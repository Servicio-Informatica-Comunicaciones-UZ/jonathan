<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = sprintf(Yii::t('jonathan', 'Usuarios del rol «%s»'), $rol);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gestión'), 'url' => ['//gestion/index']];
$this->params['breadcrumbs'][] = $this->title;

// Change background color
$this->registerCssFile('@web/css/gestion.css', ['depends' => 'app\assets\AppAsset']);
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

<div class="table-responsive">
    <?php echo GridView::widget(
        [
        'dataProvider' => new ArrayDataProvider(
            [
                'allModels' => $usuarios,
                'sort' => [
                    'attributes' => ['username', 'profile.name', 'email'],
                ],
            ]
        ),
        'columns' => [
            'username',
            'profile.name',
            'email:email',  // See http://www.yiiframework.com/doc-2.0/guide-output-formatting.html
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'quitar-rol' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('gestion', 'Quitar rol al usuario'),
                            'aria-label' => Yii::t('gestion', 'Quitar rol al usuario'),
                            'data-confirm' => Yii::t('gestion', '¿Seguro que desea eliminar este usuario del rol?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];

                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
                // 'controller' => 'gestion',
                'template' => '{quitar-rol}',
                'urlCreator' => function ($action, $model, $key, $index) use ($rol) {
                    $params = [$action, 'user_id' => $model->id, 'rol' => $rol];

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
        ]
    ); ?>
</div>

<?php \yii\widgets\Pjax::end(); ?>
<hr><br>

<?php
echo Html::a(
    '<span class="glyphicon glyphicon-plus"></span> &nbsp;' . Yii::t('jonathan', 'Añadir usuario'),
    ['asignar-rol'],  // 'rol' => $rol],
    [
        'id' => 'asignar-rol',
        'class' => 'btn btn-success',
        'title' => 'Añadir un usuario a este rol',
    ]
) . "&nbsp;\n&nbsp;";
