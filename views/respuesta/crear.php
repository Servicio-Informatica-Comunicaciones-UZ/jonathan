<?php

use yii\helpers\Html;

$this->title = Yii::t('models', 'Nueva propuesta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuestas'), 'url' => ['propuesta/listado']];
$this->params['breadcrumbs'][] = $this->title;
?>


<h1>
    <?php echo Yii::t('models', 'Nueva propuesta'); ?>
    <small>
        <?php echo Html::encode($propuesta->denominacion); ?>
    </small>
</h1>
<hr><br>

<?php echo $this->render(
    '_formulario',
    [
        'propuesta' => $propuesta,
        'models' => $models,
    ]
); ?>
