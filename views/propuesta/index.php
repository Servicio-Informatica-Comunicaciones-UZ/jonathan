<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\PropuestaSearch $searchModel
*/

$this->title = Yii::t('models', 'Propuestas');
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('cruds', 'New'), ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
?>
<div class="giiant-crud propuesta-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('models', 'Propuestas') ?>
        <small>
            List
        </small>
    </h1>
    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('cruds', 'New'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">

                                                                                                                                                                                                                                                                                                                                                                                                                                
            <?= 
            \yii\bootstrap\ButtonDropdown::widget(
            [
            'id' => 'giiant-relations',
            'encodeLabel' => false,
            'label' => '<span class="glyphicon glyphicon-paperclip"></span> ' . Yii::t('cruds', 'Relations'),
            'dropdown' => [
            'options' => [
            'class' => 'dropdown-menu-right'
            ],
            'encodeLabels' => false,
            'items' => [
            [
                'url' => ['profile/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-left"></i> ' . Yii::t('models', 'Profile'),
            ],
                                [
                'url' => ['estado/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-left"></i> ' . Yii::t('models', 'Estado'),
            ],
                                [
                'url' => ['modalidad/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-left"></i> ' . Yii::t('models', 'Modalidad'),
            ],
                                [
                'url' => ['orientacion/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-left"></i> ' . Yii::t('models', 'Orientacion'),
            ],
                                [
                'url' => ['tipo-estudio/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-left"></i> ' . Yii::t('models', 'Tipo Estudio'),
            ],
                                [
                'url' => ['user/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-left"></i> ' . Yii::t('models', 'User'),
            ],
                                [
                'url' => ['propuesta-centro/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-right"></i> ' . Yii::t('models', 'Propuesta Centro'),
            ],
                                [
                'url' => ['propuesta-doctorado/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-right"></i> ' . Yii::t('models', 'Propuesta Doctorado'),
            ],
                                [
                'url' => ['propuesta-evaluador/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-right"></i> ' . Yii::t('models', 'Propuesta Evaluador'),
            ],
                                [
                'url' => ['propuesta-grupo-inves/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-right"></i> ' . Yii::t('models', 'Propuesta Grupo Inves'),
            ],
                                [
                'url' => ['propuesta-macroarea/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-right"></i> ' . Yii::t('models', 'Propuesta Macroarea'),
            ],
                                [
                'url' => ['propuesta-titulacion/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-right"></i> ' . Yii::t('models', 'Propuesta Titulacion'),
            ],
                                [
                'url' => ['respuesta/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-right"></i> ' . Yii::t('models', 'Respuesta'),
            ],
                                [
                'url' => ['valoracion/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-right"></i> ' . Yii::t('models', 'Valoracion'),
            ],
                    
]
            ],
            'options' => [
            'class' => 'btn-default'
            ]
            ]
            );
            ?>
        </div>
    </div>

    <hr />

    <div class="table-responsive">
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
        'class' => yii\widgets\LinkPager::className(),
        'firstPageLabel' => Yii::t('cruds', 'First'),
        'lastPageLabel' => Yii::t('cruds', 'Last'),
        ],
                    'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
        'headerRowOptions' => ['class'=>'x'],
        'columns' => [
                [
            'class' => 'yii\grid\ActionColumn',
            'template' => $actionColumnTemplateString,
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('cruds', 'View'),
                        'aria-label' => Yii::t('cruds', 'View'),
                        'data-pjax' => '0',
                    ];
                    return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
                }
            ],
            'urlCreator' => function($action, $model, $key, $index) {
                // using the column name as key, not mapping to 'id' like the standard generator
                $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
                return Url::toRoute($params);
            },
            'contentOptions' => ['nowrap'=>'nowrap']
        ],
			'anyo',
			// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
			[
			    'class' => yii\grid\DataColumn::className(),
			    'attribute' => 'user_id',
			    'value' => function ($model) {
			        if ($rel = $model->user) {
			            return Html::a($rel->id, ['user/view', 'id' => $rel->id,], ['data-pjax' => 0]);
			        } else {
			            return '';
			        }
			    },
			    'format' => 'raw',
			],
			// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
			[
			    'class' => yii\grid\DataColumn::className(),
			    'attribute' => 'orientacion_id',
			    'value' => function ($model) {
			        if ($rel = $model->orientacion) {
			            return Html::a($rel->id, ['orientacion/view', 'id' => $rel->id,], ['data-pjax' => 0]);
			        } else {
			            return '';
			        }
			    },
			    'format' => 'raw',
			],
			'creditos',
			'duracion',
			// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
			[
			    'class' => yii\grid\DataColumn::className(),
			    'attribute' => 'modalidad_id',
			    'value' => function ($model) {
			        if ($rel = $model->modalidad) {
			            return Html::a($rel->id, ['modalidad/view', 'id' => $rel->id,], ['data-pjax' => 0]);
			        } else {
			            return '';
			        }
			    },
			    'format' => 'raw',
			],
			'plazas',
			/*// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
			[
			    'class' => yii\grid\DataColumn::className(),
			    'attribute' => 'tipo_estudio_id',
			    'value' => function ($model) {
			        if ($rel = $model->tipoEstudio) {
			            return Html::a($rel->id, ['tipo-estudio/view', 'id' => $rel->id,], ['data-pjax' => 0]);
			        } else {
			            return '';
			        }
			    },
			    'format' => 'raw',
			],*/
			/*// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
			[
			    'class' => yii\grid\DataColumn::className(),
			    'attribute' => 'estado_id',
			    'value' => function ($model) {
			        if ($rel = $model->estado) {
			            return Html::a($rel->id, ['estado/view', 'id' => $rel->id,], ['data-pjax' => 0]);
			        } else {
			            return '';
			        }
			    },
			    'format' => 'raw',
			],*/
			/*'creditos_practicas',*/
			/*'log:ntext',*/
			/*'denominacion',*/
			/*'memoria_verificacion',*/
			/*'memoria_economica',*/
        ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


