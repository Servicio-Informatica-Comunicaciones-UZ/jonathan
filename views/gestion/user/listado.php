<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = sprintf(Yii::t('jonathan', 'Usuarios del rol «%s»'), $rol);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gestión'), 'url' => ['//gestion/index']];
$this->params['breadcrumbs'][] = $this->title;

// Change background color
$this->registerCssFile('@web/css/gestion.css', ['depends' => 'app\assets\AppAsset']);
?>

<h1><?php echo $this->title; ?></h1>
<hr><br>

<div class="table-responsive">
    <?php echo GridView::widget([
        'dataProvider' => new ArrayDataProvider(['allModels' => $usuarios]),
        'columns' => [
            'username',
            'profile.name',
            'email',
        ],
        // 'caption' => '',
        'options' => ['class' => 'cabecera-azul'],
        'summary' => false,
        'tableOptions' => ['class' => 'table table-striped table-hover'],
    ]); ?>
</div>

<hr><br>

<?php
echo Html::a(
    '<span class="glyphicon glyphicon-plus"></span> &nbsp;' . Yii::t('jonathan', 'Crear usuario'),
    ['crear'],  // 'rol' => $rol],
    [
        'id' => 'crear',
        'class' => 'btn btn-success',
        // 'title' => '',
    ]
) . "&nbsp;\n&nbsp;";
