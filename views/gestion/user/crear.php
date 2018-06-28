<?php

use yii\helpers\Html;

$this->title = Yii::t('models', 'Nuevo usuario');
$this->params['breadcrumbs'][] = [
    'label' => sprintf(Yii::t('models', 'Usuarios del rol «%s»'), $rol),
    'url' => ['listado', 'rol' => $rol],
];
$this->params['breadcrumbs'][] = $this->title;

// Change background color
$this->registerCssFile('@web/css/gestion.css', ['depends' => 'app\assets\AppAsset']);
?>


<h1><?php echo Html::encode($this->title); ?></h1>
<hr><br>

<?php echo $this->render('_formulario', ['model' => $model, 'rol' => $rol]); ?>
