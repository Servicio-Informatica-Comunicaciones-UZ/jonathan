<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\PropuestaTitulacion $model
*/

$this->title = Yii::t('models', 'Propuesta Titulacion');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuesta Titulacions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud propuesta-titulacion-create">

    <h1>
        <?= Yii::t('models', 'Propuesta Titulacion') ?>
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
