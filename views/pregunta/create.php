<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\Pregunta $model
*/

$this->title = Yii::t('models', 'Pregunta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Preguntas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud pregunta-create">

    <h1>
        <?= Yii::t('models', 'Pregunta') ?>
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
