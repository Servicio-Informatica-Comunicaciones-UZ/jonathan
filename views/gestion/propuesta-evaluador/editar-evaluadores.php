<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = sprintf(
    Yii::t('jonathan', 'Evaluadores de «%s»'),
    Html::encode($propuesta->denominacion)
);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gestión'), 'url' => ['//gestion/index']];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('jonathan', 'Asignaciones Propuesta⟷Evaluador'),
    'url' => ['listado', 'anyo' => $propuesta->anyo],
];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?php echo $this->title; ?></h1>
<hr><br>

<ul class='listado'>
    <?php

    foreach ($propuesta->evaluadores as $evaluador) {
        printf("<li>%s</li>\n", $evaluador->profile->name);
    }
    ?>
</ul>
