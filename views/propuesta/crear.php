<?php

use yii\helpers\Html;

$this->title = Yii::t('models', 'Nueva propuesta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuestas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<h1>
    <?php echo Yii::t('models', 'Nueva propuesta'); ?>
    <small>
        <?php echo $model->id; ?>
    </small>
</h1>
<hr><br>

<div class="clearfix crud-navigation">
    <div class="pull-left">
        <?php
        echo Html::a(
            Yii::t('jonathan', 'Cancelar'),
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']
        );
        ?>
    </div>
</div>

<hr />

<?php echo $this->render('_formulario', ['model' => $model]); ?>
