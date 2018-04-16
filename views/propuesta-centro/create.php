<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\PropuestaCentro $model
*/

$this->title = Yii::t('models', 'Propuesta Centro');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuesta Centros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud propuesta-centro-create">

    <h1>
        <?= Yii::t('models', 'Propuesta Centro') ?>
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
