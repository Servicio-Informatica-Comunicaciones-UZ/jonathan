<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\Bloque $model
*/

$this->title = Yii::t('models', 'Bloque');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Bloques'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud bloque-create">

    <h1>
        <?= Yii::t('models', 'Bloque') ?>
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
