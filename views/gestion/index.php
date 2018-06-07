<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Gestión');
$this->params['breadcrumbs'][] = $this->title;
?>


<h1><?php echo $this->title; ?></h1>
<hr><br>

<ul class='listado'>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Propuestas presentadas'),
    ['//gestion/propuesta/listado-propuestas', 'anyo' => date('Y'), 'estado_id' => 2]
); ?></li>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Propuestas en borrador'),
    ['//gestion/propuesta/listado-propuestas', 'anyo' => date('Y'), 'estado_id' => 1]
); ?></li>

<li><?php echo Html::a(
    Yii::t('jonathan', 'Evaluadores'),
    ['//gestion/user/listado']  // , 'rol' => 'evaluador']
); ?></li>

</ul>