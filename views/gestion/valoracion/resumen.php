<?php

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = Yii::t('gestion', 'Resumen de valoraciones');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gestión'), 'url' => ['//gestion/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?php echo Html::encode($this->title); ?></h1>
<hr><br>

<?php
foreach ($propuestas as $bloques_propuesta) {
    $valoraciones_propuesta = call_user_func_array('array_merge', $bloques_propuesta);  // Aplana el array
    $evaluadores = array_unique(array_column($valoraciones_propuesta, 'user_id'));

    $primera_valoracion = reset($valoraciones_propuesta);
    echo '<h2>' . Html::a(
        $primera_valoracion->propuesta->denominacion,
        ['//gestion/propuesta/ver', 'id' => $primera_valoracion->propuesta_id],
        ['target' => '_blank']
    ) . "</h2>\n\n"; ?>

    <div class='table-responsive cabecera-azul'>
    <table class='table table-striped table-hover'>
    <thead>
        <tr>
        <th><?php echo Yii::t('gestion', 'Bloque'); ?></th>
        <?php
        foreach ($evaluadores as $num => $evaluador_id) {
            echo '<th>' . Html::a(
                sprintf('%s #%d', Yii::t('gestion', 'Evaluador'), $num+1),
                ['//gestion/valoracion/ver', 'user_id' => $evaluador_id, 'propuesta_id' => $primera_valoracion->propuesta_id],
                ['target' => '_blank']
            ) . "</th>\n";
        } ?>
        <th><?php echo Yii::t('gestion', 'Media'); ?></th>
        </tr>
    </thead>

    <tbody>
    <?php
    $medias_bloques = [];
    $puntos_evaluadores = [];
    foreach ($bloques as $bloque) {
        if ($bloque->tiene_puntuacion_interna) {
            continue;
        }
        $puntos_bloque = 0;

        echo "<tr>\n";
        echo "<td>{$bloque->titulo}</td>\n";

        foreach ($evaluadores as $evaluador_id) {
            $puntuacion = ArrayHelper::getValue($bloques_propuesta, [$bloque->id, $evaluador_id, 'puntuacion']);
            echo '<td>' . Yii::$app->formatter->asDecimal($puntuacion, 1) . "</td>\n";

            $puntos_bloque += $puntuacion;
            $puntos_evaluadores[$evaluador_id] = ArrayHelper::getValue($puntos_evaluadores, $evaluador_id, 0);
            $puntos_evaluadores[$evaluador_id] += $puntuacion * $bloque->porcentaje/100;
        }

        $medias_bloques[$bloque->id] = $puntos_bloque/sizeof($evaluadores);
        echo '<td>' . Yii::$app->formatter->asDecimal($medias_bloques[$bloque->id], 2) . "</td>\n";
        echo "</tr>\n";
    } ?>
    </tbody>

    <tfoot><tr>
        <td><?php echo Yii::t('gestion', 'Puntuación final'); ?></td>
        <?php
        foreach ($evaluadores as $evaluador_id) {
            printf("<td>%s</td>\n", Yii::$app->formatter->asDecimal($puntos_evaluadores[$evaluador_id], 2));
        }

        $puntuacion_final = array_sum($puntos_evaluadores) / sizeof($evaluadores);
        printf("<td>%s</td>\n", Yii::$app->formatter->asDecimal($puntuacion_final, 2)); ?>
    </tr></tfoot>
</table>
</div>
<?php
}
?>
