<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = $estado_id == 1 ? Yii::t('models', 'Propuestas en borrador') : Yii::t('models', 'Propuestas presentadas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Gestión'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?php echo $this->title; ?></h1>
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
                        trim($propuesta->denominacion) ?: '<em>' . Yii::t('jonathan', '(no definido)') . '</em>',
                        ['ver', 'id' => $propuesta->id]
                    );
                }
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
        'tableOptions' => ['class' => 'table table-striped table-hover'],
    ]); ?>
</div>
