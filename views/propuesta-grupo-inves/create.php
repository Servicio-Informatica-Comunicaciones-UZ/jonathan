<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\PropuestaGrupoInves $model
*/

$this->title = Yii::t('models', 'Propuesta Grupo Inves');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuesta Grupo Inves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud propuesta-grupo-inves-create">

    <h1>
        <?= Yii::t('models', 'Propuesta Grupo Inves') ?>
        <small>
                        <?= $model->id ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
