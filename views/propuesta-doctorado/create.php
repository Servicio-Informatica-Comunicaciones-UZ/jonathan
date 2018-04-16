<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\PropuestaDoctorado $model
*/

$this->title = Yii::t('models', 'Propuesta Doctorado');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuesta Doctorados'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud propuesta-doctorado-create">

    <h1>
        <?= Yii::t('models', 'Propuesta Doctorado') ?>
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
