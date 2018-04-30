<?php

use yii\helpers\Html;

$this->title = Yii::t('jonathan', 'Editar datos identificativos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuestas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->denominacion, 'url' => ['ver', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>


<h1>
    <?php echo Yii::t('models', 'Editar datos identificativos'); ?>
    <small>
        <?php echo Html::encode($model->denominacion); ?>
    </small>
</h1>
<hr><br>

<?php echo $this->render('_formulario', ['model' => $model]); ?>
