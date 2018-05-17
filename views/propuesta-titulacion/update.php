<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\PropuestaTitulacion $model
*/

$this->title = Yii::t('models', 'Propuesta Titulacion');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuesta Titulacion'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud propuesta-titulacion-update">

    <h1>
        <?= Yii::t('models', 'Propuesta Titulacion') ?>
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
