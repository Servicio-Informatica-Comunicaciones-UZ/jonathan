<?php

use yii\helpers\Html;
use app\models\Estado;

$this->title = Yii::t('app', 'Gestión');
$this->params['breadcrumbs'][] = $this->title;

// Change background color
$this->registerCssFile('@web/css/gestion.css', ['depends' => 'app\assets\AppAsset']);
?>


<h1><?php echo Html::encode($this->title); ?></h1>
<hr><br>

<ul class='listado'>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Propuestas en borrador'),
    ['//gestion/propuesta/listado-propuestas', 'anyo' => date('Y'), 'estado_id' => Estado::BORRADOR]
); ?></li>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Propuestas presentadas pendientes de aprobación interna'),
    ['//gestion/propuesta/listado-propuestas', 'anyo' => date('Y'), 'estado_id' => Estado::PRESENTADA]
); ?></li>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Propuestas fuera de plazo'),
    ['//gestion/propuesta/listado-propuestas', 'anyo' => date('Y'), 'estado_id' => Estado::FUERA_DE_PLAZO]
); ?></li>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Propuestas aprobadas internamente'),
    ['//gestion/propuesta/listado-propuestas', 'anyo' => date('Y'), 'estado_id' => Estado::APROB_INTERNA]
); ?></li>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Propuestas rechazadas internamente'),
    ['//gestion/propuesta/listado-propuestas', 'anyo' => date('Y'), 'estado_id' => Estado::RECHAZ_INTERNO]
); ?></li>

</ul>


<ul class='listado'>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Evaluadores'),
    ['//gestion/user/listado']  // , 'rol' => 'evaluador']
); ?></li>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Asignaciones Propuesta⟷Evaluador'),
    ['//gestion/propuesta-evaluador/listado', 'anyo' => date('Y')]
); ?></li>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Valoraciones individuales'),
    ['//gestion/propuesta-evaluador/valoraciones', 'anyo' => date('Y')]
); ?></li>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Resumen de valoraciones'),
    ['//gestion/valoracion/resumen', 'anyo' => date('Y')]
); ?></li>

</ul>