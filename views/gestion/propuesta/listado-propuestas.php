<?php

use yii\grid\GridView;
use yii\helpers\Html;
use app\models\Estado;

switch ($estado_id) {
    case Estado::BORRADOR:
        $this->title = Yii::t('jonathan', 'Propuestas en borrador');
        break;
    case Estado::PRESENTADA:
        $this->title = Yii::t('jonathan', 'Propuestas presentadas');
        break;
    case Estado::APROB_INTERNA:
        $this->title = Yii::t('jonathan', 'Propuestas aprobadas internamente');
        break;
    case Estado::APROB_EXTERNA:
        $this->title = Yii::t('jonathan', 'Propuestas aprobadas externamente');
        break;
    case Estado::RECHAZ_EXTERNA:
        $this->title = Yii::t('jonathan', 'Propuestas rechazadas externamente');
        break;
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gestión'), 'url' => ['//gestion/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?php echo $this->title; ?></h1>
<hr><br>

<div class="table-responsive">
    <?php echo GridView::widget([
        'dataProvider' => $dpPropuestas,
        'columns' => [
            [
                'attribute' => 'denominacion',
                'format' => 'html',
                'value' => function ($propuesta) {
                    return Html::a(
                        trim($propuesta->denominacion) ?: '<em>' . Yii::t('jonathan', '(no definido)') . '</em>',
                        ['//gestion/propuesta/ver', 'id' => $propuesta->id]
                    );
                }
            ], [
                'attribute' => 'user.profile.name',
                'label' => Yii::t('jonathan', 'Responsable'),
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
