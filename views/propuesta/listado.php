<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = Yii::t('models', 'Propuestas realizadas');
$this->params['breadcrumbs'][] = $this->title;
?>


<h1>
    <?php echo $this->title; ?>
    <small>
        <?php echo Html::encode(Yii::$app->user->identity->profile->name); ?>
    </small>
</h1>
<hr><br>

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
                        $propuesta->denominacion,
                        ['ver', 'id' => $propuesta->id]
                    );
                }
            ], [
                'attribute' => 'orientacion.nombre',
                'label' => Yii::t('jonathan', 'Orientación'),
            ], [
                'attribute' => 'modalidad.nombre',
                'label' => Yii::t('jonathan', 'Modalidad'),
            ], [
                'attribute' => 'estado.nombre',
                'label' => Yii::t('jonathan', 'Estado'),
            ],
        ],
        // 'caption' => '',
        'options' => ['class' => 'cabecera-azul'],
        'summary' => false,
        'tableOptions' => ['class' => 'table table-striped table-hover'],
    ]); ?>
</div>

<?php
echo Html::a(
    '<span class="glyphicon glyphicon-plus"></span> &nbsp;' . Yii::t('jonathan', 'Nueva propuesta'),
    ['crear'],
    [
        'id' => 'crear',
        'class' => 'btn btn-info',
        'title' => Yii::t('jonathan', 'Crear una nueva propuesta'),
    ]
) . "\n";
?>
