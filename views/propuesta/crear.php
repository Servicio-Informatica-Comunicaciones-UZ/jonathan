<?php

use yii\helpers\Html;

$this->title = Yii::t('models', 'Nueva propuesta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Propuestas'), 'url' => ['listado']];
$this->params['breadcrumbs'][] = $this->title;
?>


<h1><?php echo Yii::t('models', 'Nueva propuesta'); ?></h1>
<hr><br>

<?php echo $this->render('_formulario-fase-1', ['model' => $model]); ?>
