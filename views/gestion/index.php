<?php

use yii\helpers\Html;
use app\models\Estado;

$this->title = Yii::t('app', 'Gestión');
$this->params['breadcrumbs'][] = $this->title;
# $anyo_academico = date('m') < 10 ? date('Y') - 1 : date('Y');
$anyo_academico = date('Y');  # TODO: Hacerlo configurable.

// Change background color
$this->registerCssFile('@web/css/gestion.css', ['depends' => 'app\assets\AppAsset']);
?>


<h1><?php echo Html::encode($this->title); ?></h1>
<hr><br>

<ul class='listado'>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Propuestas'),
    ['//gestion/propuesta/listado-propuestas', 'anyo' => $anyo_academico]
); ?></li>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Evaluadores'),
    ['//gestion/user/listado']  // , 'rol' => 'evaluador']
); ?></li>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Asignaciones Propuesta⟷Evaluador'),
    ['//gestion/propuesta-evaluador/listado', 'anyo' => $anyo_academico]
); ?></li>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Valoraciones individuales'),
    ['//gestion/propuesta-evaluador/valoraciones', 'anyo' => $anyo_academico]
); ?></li>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Resumen de valoraciones (fase 1)'),
    ['//gestion/valoracion/resumen', 'anyo' => $anyo_academico, 'fase' => 1]
); ?></li>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Resumen de valoraciones (fase 2)'),
    ['//gestion/valoracion/resumen', 'anyo' => $anyo_academico, 'fase' => 2]
); ?></li>

</ul>