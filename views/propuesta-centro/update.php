<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\PropuestaCentro $model
*/

$this->title = Yii::t('models', 'Propuesta Centro');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuesta Centro'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud propuesta-centro-update">

    <h1>
        <?= Yii::t('models', 'Propuesta Centro') ?>
        <small>
                        <?= $model->id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
